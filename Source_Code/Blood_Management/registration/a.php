<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Date Picker Example</title>
<style>
  .field {
    margin-bottom: 10px;
  }

  label {
    display: block;
    margin-bottom: 5px;
  }

  input[type="date"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .help {
    color: red;
    font-size: 12px;
  }
</style>
</head>
<body>

<form action="submit.php" method="POST">
  <div class="field">
    <label for="DOB">DOB:</label>
    <input id="DOB" name="DOB" type="date" value="<?php if (!empty($dob)) echo $dob; ?>"
      onblur="validateNonEmpty(this, document.getElementById('DOB_help'))" />
    <span id="DOB_help" class="help"></span>
  </div>

  <!-- Other form fields can be added here -->

  <button type="submit">Submit</button>
</form>

<script>
  function validateNonEmpty(input, helpElement) {
    if (input.value.trim() === '') {
      helpElement.textContent = 'Please enter your date of birth.';
    } else {
      helpElement.textContent = '';
    }
  }
</script>

</body>
</html>
