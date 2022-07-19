<?php

declare(strict_types=1);

class Posts extends Controller
{

    private Post $postModel;
    private User $userModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index(): void
    {
        // Get posts
        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts
        ];

        $this->view('posts/index', $data);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $data = $this->getPostArray();

            // Make sure there is no error
            if (empty($data['tittle_error']) && empty($data['body_error'])) {
                // Validation passed
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post added');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('posts/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];
            $this->view('posts/add', $data);
        }
    }

    public function edit(string $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $data = $this->getPostArray();
            $data['id'] = $id;
            // Make sure there is no error
            if (empty($data['tittle_error']) && empty($data['body_error'])) {
                // Validation passed
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post updated');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('posts/edit', $data);
            }
        } else {
            // Get existing post from model
            $post = $this->postModel->getPost($id);

            //Check for the owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
            $this->view('posts/edit', $data);
        }
    }

    public function show(string $id)
    {
        $post = $this->postModel->getPost($id);
        $user = $this->userModel->getUserById($post->user_id);
        $data = [
            'post' => $post,
            'user' => $user
        ];
        $this->view('posts/show', $data);
    }

    /**
     * @return array
     */
    public function getPostArray(): array
    {
        $_POST['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES);
        $_POST['body'] = htmlspecialchars($_POST['body'], ENT_QUOTES);

        $data = [
            'title' => trim($_POST['title']),
            'body' => trim($_POST['body']),
            'user_id' => $_SESSION['user_id'],
            'title_error' => '',
            'body_error' => ''
        ];

        // Validate data
        if (empty($data['title'])) {
            $data['title_error'] = 'Please input title of the post';
        }
        if (empty($data['body'])) {
            $data['body_error'] = 'Please input body of the post';
        }
        return $data;
    }

    public function delete(string $id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Get existing post from model
            $post = $this->postModel->getPost($id);

            //Check for the owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }
            if($this->postModel->deletePost($id)) {
                flash('post_message', 'Post deleted');
                redirect('posts');
            } else {
                die('Something went wrong');
            }

        } else {
            redirect('posts');
        }
    }



}