<?php
// Initialize variables for the uploaded image path and other inputs
$image_path = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $image_url = htmlspecialchars($_POST['image_url']);
    $caption = htmlspecialchars($_POST['caption']);
    $personal_background = htmlspecialchars($_POST['personal_background']);
    $academic_background = htmlspecialchars($_POST['academic_background']);
    $background_subject = htmlspecialchars($_POST['background_subject']);
    $computer_platform = htmlspecialchars($_POST['computer_platform']);
    $courses = $_POST['courses'];
    $funny_item = htmlspecialchars($_POST['funny_item'] ?? '');
    $share = htmlspecialchars($_POST['share'] ?? '');

    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['image']['name']);
        $upload_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $image_path = $upload_file;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ken Wabibi's Keen Whale 🐋 Introduction Form</title>
    <link rel="stylesheet" href="styles/intro_form.css">
    <script src="https://lint.page/kit/67ff88.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <main>
        <h2>Introduction Form</h2>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <figure>
                <?php if ($image_path): ?>
                    <img src="<?= $image_path ?>" alt="Uploaded Image">
                <?php else: ?>
                    <img src="<?= $image_url ?>" alt="Photo of <?= $name ?>">
                <?php endif; ?>
                <figcaption><em><?= $caption ?></em></figcaption>
            </figure>
            <ul>
                <li><strong>Personal background:</strong> <?= $personal_background ?></li>
                <li><strong>Academic background:</strong> <?= $academic_background ?></li>
                <li><strong>Background in this subject:</strong> <?= $background_subject ?></li>
                <li><strong>Primary Computer Platform:</strong> <?= $computer_platform ?></li>
                <li><strong>Courses I'm Taking & Why:</strong>
                    <ul class="course-list">
                        <?php
                        $bold_courses = [
                            'CSC221 Advanced Python',
                            'CTS240 Project Management',
                            'WEB115 Web Markup and Scripting',
                            'WEB140 Web Development Tools',
                            'WEB250 Database Driven Websites'
                        ];

                        foreach ($courses as $course) {
                            $course_safe = htmlspecialchars($course);
                            $course_name = explode(' - ', $course_safe)[0];
                            if (in_array($course_name, $bold_courses)) {
                                echo "<li><strong>$course_safe</strong></li>";
                            } else {
                                echo "<li>$course_safe</li>";
                            }
                        }
                        ?>
                    </ul>
                </li>
                <li><strong>Funny/Interesting item about yourself:</strong> <?= $funny_item ?></li>
                <li><strong>I'd also like to share:</strong> <?= $share ?></li>
            </ul>

            <form method="GET" action="">
                <button type="submit" id="reset-btn">Reset Form</button>
            </form>

        <?php else: ?>
            <form method="POST" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="Ken" placeholder="Enter your name">

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image">

                <label for="image_url">Image URL (optional):</label>
                <input type="text" id="image_url" name="image_url" value="images/ck_resized3.png" placeholder="Enter image URL">

                <label for="caption">Caption:</label>
                <textarea id="caption" name="caption" placeholder="Enter your caption">With my dog Chance</textarea>

                <label for="personal_background">Personal Background:</label>
                <textarea id="personal_background" name="personal_background" placeholder="Enter your personal background">Born and raised in Charlotte, NC. I’m a unicorn.</textarea>

                <label for="academic_background">Academic Background:</label>
                <textarea id="academic_background" name="academic_background" placeholder="Enter your academic background">I graduated from Olympic High School then attended Livingstone College for a year...</textarea>

                <label for="background_subject">Background in This Subject:</label>
                <textarea id="background_subject" name="background_subject" placeholder="Enter your background in the subject">I’m new to programming. I took my first programming class which was C++ Fall 2023...</textarea>

                <label for="computer_platform">Primary Computer Platform:</label>
                <input type="text" id="computer_platform" name="computer_platform" value="macOS Monterey laptop" placeholder="Enter your platform">

                <label>Courses You're Taking & Why:</label>
                <div id="courses-container">
                    <?php
                    $default_courses = [
                        "CSC221 Advanced Python - It’s required for my major, but I also want to improve my python programming skills.",
                        "CTS240 Project Management - This class will help me get an inside look...",
                        "WEB115 Web Markup and Scripting - I want to better my understanding...",
                        "WEB140 Web Development Tools - I’m interested about the new knowledge...",
                        "WEB250 Database Driven Websites - I want to learn about CRUD..."
                    ];
                    foreach ($default_courses as $course): ?>
                        <div class="course-input">
                            <input type="text" name="courses[]" value="<?= htmlspecialchars($course) ?>">
                            <button type="button" class="remove-course-btn">Remove Course</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="add-course-btn">Add Course</button>

                <label for="funny_item">Funny/Interesting Item About Yourself:</label>
                <textarea id="funny_item" name="funny_item" placeholder="Enter something funny or interesting">I once got chased by a goat while delivering mail.</textarea>

                <label for="share">Anything Else You'd Like to Share:</label>
                <textarea id="share" name="share" placeholder="Share something extra">I’m excited to learn new web development skills!</textarea>

                <button type="submit">Submit</button>
            </form>

            <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <button type="submit" id="reset-btn">Reset Form</button>
            </form>
        <?php endif; ?>
    </main>

    <?php include 'components/footer.php'; ?>
    <script src="scripts/intro_form.js"></script>
</body>
</html>
