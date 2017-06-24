<?php
namespace mangescom\service\blog;

interface BlogService {
	public function ShowBlog();
	public function ShowVideo();
	public function ShowPost($id);
	public function ShowComments($id);
	public function PostComment($id, $comment);
	public function SearchPosts($keyword);
	public function EditVideo($id, $token);
	public function EditBlog($id, $token);
	public function DeleteVideo($id);
	public function DeleteBlog($id);
	public function PostVideo($id, $title, $url);
	public function PostBlog($id, $title, $text, $image);
}


