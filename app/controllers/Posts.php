<?php
class Posts extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');

    }
    public function index()
    {

        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts,
        ];
        $this->view('posts/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'Please write content';
            }

            if (empty($data['title_err']) && empty($data['body_err'])) {
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post Added');
                    redirect('posts');
                }
            } else {
                $this->view('posts/add', $data);
            }

        } else {
            $data = [
                'title' => '',
                'body' => '',
            ];
        }

        $this->view('posts/add', $data);
    }

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);
        $data = [
            'post' => $post,
            'user' => $user,
        ];
        $this->view('posts/show', $data);
    }

    public function edit($id)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $imageName = $_FILES['image']['name'];
            $target = dirname(APPROOT) . '/public/img/' . $imageName;
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'image' => $imageName,
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
                'img_err' => '',
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'Please write content';
            }
            if ($_FILES['image']['size'] >= 100000000) {
                $data['body_err'] = 'Exceeded filesize limit';
            }
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($_FILES['image']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true)) {
                $data['body_err'] = 'Invalid file format.';
            }
            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            try {

                // You should name it uniquely.
                // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                // On this example, obtain safe unique name from its binary data.
                if (!move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    sprintf($target,
                        sha1_file($_FILES['image']['tmp_name']),
                        $ext
                    )
                )) {
                    $data['body_err'] = 'move files';
                }

            } catch (RuntimeException $e) {

                $data['body_err'] = $e->getMessage();

            }

            if (empty($data['title_err']) && empty($data['body_err']) && empty($data['img_err'])) {
                if ($this->postModel->updatePost($data)) {

                    flash('post_message', 'Post Updated');
                    redirect('posts');

                }

            } else {
                $this->view('posts/edit', $data);
            }

        } else {
            $post = $this->postModel->getPostById($id);

            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body,
                'image' => $post->image,
            ];
        }

        $this->view('posts/edit', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('posts');
            } else {
                die('Something went wrong!');
            }
        } else {
            redirect('posts');
        }
    }

    public function printpost()
    {
        $posts = $this->postModel->getPosts();
        $stylesheet = file_get_contents(URLROOT . "/css/pdf.css");

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML('<h1>Record Files</h1><table>');

        foreach ($posts as $post) {
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

    public function printOne($id)
    {
        $post = $this->postModel->getPostById($id);
        $stylesheet = file_get_contents(URLROOT . "/css/pdf.css");

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML('<h1>Record</h1><table>');
        $user = $this->userModel->getUserById($post->user_id);
        $content = ('<tr>');
        $content .= $this->pageFormat($post->title, 'th');
        $content .= $this->pageFormat($user->name, 'td');
        $content .= $this->pageFormat($post->created_at, 'td');
        $content .= ('<tr>');
        $mpdf->WriteHTML($content);
        $mpdf->WriteHTML('</table><br>');
        $mpdf->WriteHTML($post->body);
        $link = '<br><a href= "https://www.youtube.com/watch?v=9oc8Fa7tb8c">
        <img src= "' . URLROOT . ' /img/scoreThumb.png" alt="HTML tutorial" style="width:256px;height:144px;border:0;">
      </a>';
        $mpdf->WriteHTML($link);
        $mpdf->Output('posts.pdf', 'I');
    }
    public function upload()
    {

    }

    public function cutLength($var, $length)
    {
        if (strlen($var) > $length) {
            $var = substr($var, 0, $length) . '...';
        }
        return ($var);
    }

    public function pageFormat($postData, $tag)
    {
        $content = ('<' . ($tag) . '>' . ($postData) . '</' . ($tag) . '>');
        return $content;
    }
}
