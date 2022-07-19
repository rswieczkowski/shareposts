<?php

class Pages extends Controller
{
    private Post $postModel;

    public function __construct()
    {
    }

    public function index()
    {
        if(isLoggedIn()) {
            redirect('posts');
        }

        $data = [
            'title' => 'Share Posts',
            'description'=>'Simple social network built on MVC PHP framework'
        ];


        $this->view('pages/index', $data);
    }


    public function about()
    {
        $data = [
            'title' => 'About',
            'description'=>'Simple app to share posts with other users'

        ];
        $this->view('pages/about', $data);
    }
}

