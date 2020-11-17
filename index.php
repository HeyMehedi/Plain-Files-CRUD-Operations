<?php
require_once "inc/functions.php";

$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';
if ('seed' == $task) {
    seed();
    $error = 2;
}
if ('delete' == $task) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if ($id > 0) {
        deleteStudent($id);
        header('location: /');
    }
}
$fname = '';
$lname = '';
$roll = '';
if (isset($_POST['submit'])) {
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

    if ($id) {
        // Update the existing student
        if ($fname != '' && $lname != '' && $roll != '') {
            $result = updateStudent($id, $fname, $lname, $roll);
            if ($result) {
                header('location: /');
            } else {
                $error = 1;
            }
        }
    } else {
        // Add a new student
        if ($fname != '' && $lname != '' && $roll != '') {
            $result = addStudent($fname, $lname, $roll);
            if ($result) {
                header('location: / ');
            } else {
                $error = 1;
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CRUD Project</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="Md Mehedi Hasan">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <!-- CSS Reset -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <!-- Milligram CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>Project Name: CRUD</h2>
                <p>A sample project to perform CRUD operations using plain file and PHP</p>
                <?php include_once 'inc/templates/nav.php';?>
            </div>
        </div>
    </div>

    <?php if (errorMessge($error) != ''): ?>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
            <?php echo "<blockquote>" . errorMessge($error) . "</blockquote>"; ?>
            </div>
        </div>
    </div>
    <?php endif;?>

    <?php if ('report' == $task): ?>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
            <?php generateReport();?>
            </div>
        </div>
    </div>
    <?php endif;?>

    <?php if ('add' == $task): ?>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="/?task=add" method="POST">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" value="<?php echo $fname; ?>">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" value="<?php echo $lname; ?>">
                    <label for="roll">Roll</label>
                    <input type="number" name="roll" value="<?php echo $roll; ?>">
                    <button type="submit" name="submit"> Save </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif;?>


    <?php
if ('edit' == $task):
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $student = getStudent($id);
    if ($student): ?>
	            <div class="container">
	                <div class="row">
	                    <div class="column column-60 column-offset-20">
	                        <form action="/?task=add" method="POST">
	                            <input type="hidden" value="<?php echo $id; ?>" name="id">
	                            <label for="fname">First Name</label>
	                            <input type="text" name="fname" value="<?php echo $student['fname']; ?>">
	                            <label for="lname">Last Name</label>
	                            <input type="text" name="lname" value="<?php echo $student['lname']; ?>">
	                            <label for="roll">Roll</label>
	                            <input type="number" name="roll" value="<?php echo $student['roll']; ?>">
	                            <button type="submit" name="submit"> Update </button>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        <?php
endif;
endif;
?>
    <script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>
