<?php
require_once 'db_connect.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
// handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? 'Other');
    if ($title === '' || $description === '') {
        $_SESSION['success'] = "Please provide both title and description.";
        header('Location: submit_idea.php');
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO ideas (title, description, category) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $title, $description, $category);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Your idea has been submitted — thanks for pitching!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['success'] = "Error submitting idea. Please try again.";
        header('Location: submit_idea.php');
        exit;
    }
}
include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card card-glass p-4">
      <h4 class="mb-3">Pitch an Idea</h4>
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
      <?php endif; ?>
      <form method="POST" action="submit_idea.php" id="idea-form">
        <div class="mb-3">
          <label class="form-label">Idea Title</label>
          <input name="title" required class="form-control form-input" placeholder="e.g., Smart Waste Bin for Campus">
        </div>
        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category" class="form-select form-input">
            <option>Tech</option>
            <option>Health</option>
            <option>Education</option>
            <option>Environment</option>
            <option>Finance</option>
            <option>Other</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Short Description</label>
          <textarea name="description" required rows="6" class="form-control form-input" placeholder="Explain the problem and your solution..."></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <a href="index.php" class="btn btn-outline-secondary">Back</a>
          <button class="btn btn-pill btn-primary" type="submit">Submit Idea</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
