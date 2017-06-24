<?php
namespace mangescom\service\blog;

use mangescom\SimpleTemplateEngine;

class BlogPDOService implements BlogService {
	
	private $pdo;
  	private $template;
  	
	public function __construct(\PDO $pdo, SimpleTemplateEngine $template) {
		$this->pdo = $pdo;
		$this->template = $template;
	}
	
	public function ShowBlog(){
		$stmt = $this->pdo->prepare("SELECT blogpost.id, created, title, text, image, user.vorname, user.nachname FROM blogpost inner join user On author = user.Id ORDER BY blogpost.id");
		$stmt->execute();
		
		if ($stmt->rowCount() > 0)
		{
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				echo $this->template->render("blogposts.html.php",
						[
								"id"		=> $row[0],
								"created" 	=> date( 'Y.m.d', strtotime( $row[1] ) ),
								"title" 	=> $row[2],
								"text"		=> substr($row[3], 0, 150) . '...',
								"image" 	=> $row[4],
								"author" 	=> $row[5].' '.$row[6]
		
						]);
			}
		}
	}
	
	public function ShowVideo(){
		$stmt = $this->pdo->prepare("SELECT video.id, posted, title, url, user.vorname, user.nachname FROM video inner join user On author = user.Id ORDER BY video.id");
		$stmt->execute();
		
		if ($stmt->rowCount() > 0)
		{
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				echo $this->template->render("video.html.php",
						[
								"id"		=> $row[0],
								"posted"	=> date( 'Y.m.d', strtotime( $row[1] ) ),
								"title" 	=> $row[2],
								"url" 		=> $row[3],
								"author" 	=> $row[4].' '.$row[5]
		
						]);
			}
		}
	}
	
	public function ShowPost($id){
		$stmt = $this->pdo->prepare("SELECT blogpost.id, created, title, text, image, user.vorname, user.nachname FROM blogpost inner join user On author = user.Id WHERE blogpost.id=?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
	
		if ($stmt->rowCount() == 1)
		{
			$row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT);
			echo $this->template->render("header.html.php", ["title" => $row[2]]);
			echo $this->template->render("blogpost.html.php",
					[
							"created" 	=> date( 'Y.m.d', strtotime( $row[1] ) ),
							"text"		=> $row[3],
							"image" 	=> $row[4],
							"author" 	=> $row[5].' '.$row[6]
	
					]);
		}
	}	

	public function ShowComments($id){
		$stmt = $this->pdo->prepare("SELECT comment, posted, user.vorname, user.nachname FROM comment inner join user On author = user.Id WHERE post = ? ORDER BY comment.id");
		$stmt->bindValue(1, $id);
		$stmt->execute();
	
		if ($stmt->rowCount() > 0)
		{
			$i = 0;
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				echo $this->template->render("comments.html.php",
						[
								"comment" 	=> $row[0],
								"posted"	=> date( 'Y.m.d', strtotime( $row[1] ) ),
								"author" 	=> $row[2].' '.$row[3]
	
						]);
				$i++;
			}
		}
	}

	public function PostComment($id, $comment)
	{
		$stmt = $this->pdo->prepare("INSERT INTO comment (comment, author, post, posted) VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
		$stmt->bindValue(1, $comment);
		$stmt->bindValue(2, $_SESSION["user"]);
		$stmt->bindValue(3, $id);
		if($stmt->execute()){
			return true;
		}
		else{
			return false;
		}
	}

	public function SearchPosts($keyword) {
		$stmt = $this->pdo->prepare("SELECT blogpost.id, created, title, text, image, user.vorname, user.nachname FROM blogpost inner join user On author = user.Id WHERE text LIKE CONCAT('%',?,'%') OR title LIKE CONCAT('%',?,'%')");
		$stmt->bindValue(1, $keyword);
		$stmt->bindValue(2, $keyword);
		$stmt->execute();
	
		if ($stmt->rowCount() > 0)
		{
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				echo $this->template->render("blogposts.html.php",
						[
								"id"		=> $row[0],
								"created" 	=> date( 'Y.m.d', strtotime( $row[1] ) ),
								"title"		=> $row[2],
								"text"		=> $row[3],
								"image" 	=> $row[4],
								"author" 	=> $row[5].' '.$row[6]
	
						]);
			}
		}
		else{
			echo "<h1>No Blogposts match your criteria</h1>";
		}
	}
	
	public function EditVideo($id, $token){
		$stmt = $this->pdo->prepare("SELECT id, title, url FROM video WHERE id = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
	
		if ($stmt->rowCount() == 1)
		{
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				echo $this->template->render("videoedit.html.php",
						[
								"id"		=> $row[0],
								"title" 	=> $row[1],
								"url" 		=> $row[2],
								"token"		=> $token
									
						]);
			}
		}
	}
	
	public function EditBlog($id, $token){
		$stmt = $this->pdo->prepare("SELECT id, title, text, image FROM blogpost WHERE id = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
	
		if ($stmt->rowCount() == 1)
		{
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				echo $this->template->render("blogedit.html.php",
						[
								"id"		=> $row[0],
								"title" 	=> $row[1],
								"text" 		=> $row[2],
								"image"		=> $row[3],
								"token"		=> $token
									
						]);
			}
		}
	}

	public function PostVideo($id, $title, $url){
		if($id == 0){
			$stmt = $this->pdo->prepare("INSERT INTO video (url, title, posted, author) VALUES (?, ?, CURRENT_TIMESTAMP, ?)");
			$stmt->bindValue(1, $url);
			$stmt->bindValue(2, $title);
			$stmt->bindValue(3, $_SESSION["user"]);
		}
		else{
			$stmt = $this->pdo->prepare("UPDATE video SET url = ?, title= ?, posted = CURRENT_TIMESTAMP, author = ? WHERE id = ?");
			$stmt->bindValue(1, $url);
			$stmt->bindValue(2, $title);
			$stmt->bindValue(3, $_SESSION["user"]);
			$stmt->bindValue(4, $id);
		}
		if($stmt->execute()){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function PostBlog($id, $title, $text, $image){
		if($id == 0){			
			$stmt = $this->pdo->prepare("INSERT INTO blogpost (created, title, text, image, author) VALUES (CURRENT_TIMESTAMP, ?, ?, ?, ?)");
			$stmt->bindValue(1, $title);
			$stmt->bindValue(2, $text);
			$stmt->bindValue(3, $image);
			$stmt->bindValue(4, $_SESSION["user"]);
		}
		else{
			$stmt = $this->pdo->prepare("UPDATE blogpost SET created = CURRENT_TIMESTAMP, title= ?, text = ?, image = ?, author = ? WHERE id = ?");
			$stmt->bindValue(1, $title);
			$stmt->bindValue(2, $text);
			$stmt->bindValue(3, $image);
			$stmt->bindValue(4, $_SESSION["user"]);
			$stmt->bindValue(5, $id);
		}
		if($stmt->execute()){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function DeleteVideo($id){
		$stmt = $this->pdo->prepare("DELETE FROM video WHERE id=?");
		$stmt->bindValue(1, $id);
	
		if($stmt->execute()){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function DeleteBlog($id){
		$this->pdo->beginTransaction();
			$stmt = $this->pdo->prepare("DELETE FROM comment WHERE post=?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			$stmt = $this->pdo->prepare("DELETE FROM blogpost WHERE id=?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
		$this->pdo->commit();
		return true;
	}
	
}
	
	