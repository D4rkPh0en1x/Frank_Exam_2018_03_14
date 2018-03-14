<?php
//Create a form to add a movie and make the necessary checks.
//Prerequisites :
//The fields "title, name of the director, actors, producer and synopsis" will have at
//least 5 characters.
//The fields: year of production, language, category, must be a drop-down menu
//The link for the trailer must be a valid URL
//In case of input errors, error messages will be displayed in red
//Each movie will be added to the created database.. A "success" message will confirm the
//addition of the film.


require_once __DIR__.'/../../vendor/autoload.php';

$configs = require __DIR__. '/../../config/app.conf.php';

Service\DBConnector::setConfig($configs['db']);

try{
    $connection = Service\DBConnector::getConnection();
} catch (\PDOException $exception) {
    http_response_code(500);
    echo 'Impossible to connect to the DB, contact the support';
    exit(10);
}

$sqlMovieLanguages = 'SELECT * FROM language';
$statementMovieLanguages = $connection->prepare($sqlMovieLanguages);
$statementMovieLanguages->execute();
$allMovieLanguages = $statementMovieLanguages->fetchall();

$sqlMovieCategories = 'SHOW COLUMNS FROM movies WHERE field="category"';
$statementMovieCategories = $connection->prepare($sqlMovieCategories);
$statementMovieCategories->execute();
$allMovieCategories = $statementMovieCategories->fetch(PDO::FETCH_ASSOC);


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $movieTitle = $_POST["movieTitle"] ?? null;
    $movieDirector = $_POST["movieDirector"] ?? null;
    $movieActors = $_POST["movieActors"] ?? null;
    $movieProducer = $_POST["movieProducer"] ?? null;
    $movieStoryline = $_POST["movieStoryline"] ?? null;
    $movieYear = $_POST["movieYear"] ?? null;
    $movieLanguage = $_POST["movieLanguage"] ?? null;
    $movieCategory = $_POST["movieCategory"] ?? null;
    $movieVideo = $_POST["movieVideo"] ?? null;
    
    if($movieTitle >4 || $movieDirector >4 || $movieActors >4 || $movieProducer >4 || $movieStoryline >4 || filter_var($movieVideo, FILTER_VALIDATE_URL) === FALSE ){
       echo '<span style="color:red;text-align:center;">You have an error in your entry -> Pay attention that the title, director, actors, producer and storyline must have at least 5 charackters</span>';
       echo '<br/>';
       echo '<span style="color:red;text-align:center;">Also the given Trailer link must have a valid URL</span>';
       return;
    }

    
    $sql = 'INSERT INTO movies (title,actors,director,producer,year_of_prod,language,category,storyline,video) values (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $statementInsertMovie = $connection->prepare($sql);
    $statementInsertMovie->execute(array($movieTitle,$movieActors,$movieDirector,$movieProducer, $movieYear, $movieLanguage, $movieCategory, $movieStoryline, $movieVideo));

    if($statementInsertMovie->execute()){
        echo 'Data saved succesfull';
    }
    
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie Database - EXAM</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


</head>
<body>
	<h1>Welcome to the Movie Database</h1>
	<h4>Create a new movie</h4>


<form action="/exo_03/step_2/src/Controller/create.php" method="post">
  <div>
    <label>Title</label>
    <div>
        <input name="movieTitle" type="text" size="35" placeholder="Movie Title">
        <?php if (!empty($movietitleError)): ?>
          <span><?php echo $movietitleError;?></span>
        <?php endif; ?>
    </div>
  </div>
  <div>
    <label>Movie Actors</label>
    <div>
      <input name="movieActors" type="text" size="35" placeholder="Movie Actors">
      <?php if (!empty($movieActorsError)): ?>
        <span><?php echo $movieActorsError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div>
    <label>Movie Director</label>
    <div>
      <input name="movieDirector" type="text" size="35" placeholder="Movie Director">
      <?php if (!empty($movieDirectorError)): ?>
        <span><?php echo $movieDirectorError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div>
    <label>Movie Producer</label>
    <div>
      <input name="movieProducer" type="text" size="35" placeholder="Movie Producer">
      <?php if (!empty($movieProducerError)): ?>
        <span><?php echo $movieProducerError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div>
    <label>Year of Production</label>
    <div>
      <?php
      echo '<select id="movieYear" name="movieYear" placeholder="Year of Production">';
      
      for($iteration = 2018 ; $iteration >= 1950 ; $iteration--) {
          echo "<option value=$iteration>" . $iteration . "</option>";
         }
      echo "</select>";
      if (!empty($movieYearError)): ?>
      <span><?php echo $movieYearError;?></span>
  	  <?php endif;
      ?>
    </div>
  </div>
  <div>
    <label>Language</label>
    <div>
      <?php
      echo '<select id="movieLanguage" name="movieLanguage" placeholder="Language">';
      foreach ($allMovieLanguages as $row){
          echo "<option value='" . $row['id'] . "'>" . $row['name_en'] . "</option>";
      }
      echo "</select>";
      if (!empty($movieLanguageError)): ?>
      <span><?php echo $movieLanguageError;?></span>
  	  <?php endif;
      ?>
    </div>
  </div>
  
  <div>
    <label>Category</label>
    <div>
      <input name="movieCategory" type="number" size="35" placeholder="Category">
      <?php if (!empty($movieCategoryError)): ?>
        <span><?php echo $movieCategoryError;?></span>
      <?php endif; ?>
    </div>
  </div>
  
  
<select>
<?
foreach(explode("','",substr($allMovieCategories['Type'],6,-2)) as $option) {
    print("<option value='$option'>$option</option>");
}
?>
</select>


  
  <div>
    <label>Storyline</label>
    <div>
      <textarea name="movieStoryline" placeholder="Storyline" rows="5" cols="80"></textarea>
      <?php if (!empty($movieStorylineError)): ?>
        <span> <?php echo $movieStorylineError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div>
    <label>Trailer Link</label>
    <div>
      <input name="movieTrailer" type="text" size="35" placeholder="Trailer Link">
      <?php if (!empty($movieTrailerError)): ?>
        <span><?php echo $movieTrailerError;?></span>
      <?php endif; ?>
    </div>
  </div>
  <div>
    <button type="submit" class="btn btn-success">Create</button>
    <a class="btn btn-info" href="/exo_03/step_2/public/">Back</a>
  </div>
</form>
  	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
