<?php
class Posts extends Controller {
    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');

    }
    public function index(){

        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    public function add(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            if(empty($data['title'])){
                $data['title_err'] = 'Please enter title';
            }

            if(empty($data['body'])){
                $data['body_err'] = 'Please write content';
            }

            if(empty($data['title_err']) && empty($data['body_err'])){
                if($this->postModel->addPost($data)){
                    flash('post_message', 'Post Added');
                    redirect('posts');
                }
            } else {
               $this->view('posts/add', $data);
            }

        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];
        }
        
        $this->view('posts/add', $data);
    }

    public function show($id){
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);
        $data = [
            'post' => $post,
            'user' => $user
        ];
        $this->view('posts/show', $data);
    }

    public function edit($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            if(empty($data['title'])){
                $data['title_err'] = 'Please enter title';
            }

            if(empty($data['body'])){
                $data['body_err'] = 'Please write content';
            }

            if(empty($data['title_err']) && empty($data['body_err'])){
                if($this->postModel->updatePost($data)){
                    flash('post_message', 'Post Updated');
                    redirect('posts');
                }
            } else {
               $this->view('posts/add', $data);
            }

        } else {
            $post = $this->postModel->getPostById($id);

            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
        }
        
        $this->view('posts/edit', $data);
    }

    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($this->postModel->deletePost($id)){
                flash('post_message', 'Post Removed');
                redirect('posts'); 
            } else{
                die('Something went wrong!');
            }
        } else {
            redirect('posts');
        }
    }
    
    public function printpost(){
        $posts = $this->postModel->getPosts();
        $stylesheet= file_get_contents(URLROOT. "/css/pdf.css");

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML('<h1>Record Files</h1><table>');
        
        foreach($posts as $post)
        {
            $user = $this->userModel->getUserById($post->user_id);
            $content = ('<tr>');
            $content .= $this->pageFormat($post->title, 'th');
            $content .= $this->pageFormat($user->name, 'td');
            $var = $this->cutLength($post->body, 50);
            $content .= $this->pageFormat($var, 'td');
            $content .= $this->pageFormat($post->created_at, 'td');
            $content .= ('<tr>');
           $mpdf->WriteHTML($content);
        }
        $mpdf->WriteHTML('</table>');
        $mpdf->Output('posts.pdf', 'I');
    }

    public function printOne($id){
        $post = $this->postModel->getPostById($id);
        $stylesheet= file_get_contents(URLROOT. "/css/pdf.css");

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML('<h1>Record</h1><table>');
            $user = $this->userModel->getUserById($post->user_id);
            $content = ('<tr>');
            $content .= $this->pageFormat($post->title, 'th');
            $content .= $this->pageFormat($user->name, 'td');
            $content .= $this->pageFormat($post->body, 'td');
            $content .= $this->pageFormat($post->created_at, 'td');
            $content .= ('<tr>');
           $mpdf->WriteHTML($content);
        $mpdf->WriteHTML('</table>');
        $mpdf->Output('posts.pdf', 'I');
    }

    public function cutLength($var, $length)
    {
        if(strlen($var) > $length){
            $var = substr($var,0,$length). '...';
        }
        return($var);
    }

    public function pageFormat($postData, $tag){
        $content = ('<'. ($tag) .'>'.($postData).'</'. ($tag). '>');
        return $content;
    }
}