<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>

<h2>Add User</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('user/add'); ?>

    <label for="username">Username:</label>
    <input type="text" name="username" /><br /><br />

    <label for="email">Email:</label>
    <input type="text" name="email" /><br /><br />

    <label for="password">Password:</label>
    <input type="password" name="password" /><br /><br />

    <input type="submit" name="submit" value="Add User" />

</form>

</body>
</html>
