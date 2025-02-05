<?php
include '../connection.php';

$data = [];

// Check if adviser_id is set
if (isset($_POST['adviser_id'])) {
    // Sanitize the input and cast to an integer
    $adviser_id = intval($_POST['adviser_id']);
    
    // Check if adviser_id is a valid integer greater than 0
    if ($adviser_id > 0) {
        // Use a prepared statement to prevent SQL injection
        $query = "UPDATE advisers SET archived = 1 WHERE adviser_id = ?"; // Assuming 'id' is the correct column
        if ($stmt = mysqli_prepare($conn, $query)) {
            // Bind the parameter to the prepared statement
            mysqli_stmt_bind_param($stmt, 'i', $adviser_id);
            
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $data['success'] = true;
                $data['message'] = 'Adviser archived successfully!';
            } else {
                $data['success'] = false;
                $data['message'] = 'Failed to archive adviser: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt); // Close the prepared statement
        } else {
            $data['success'] = false;
            $data['message'] = 'Error preparing the query: ' . mysqli_error($conn);
        }
    } else {
        $data['success'] = false;
        $data['message'] = 'Invalid adviser ID.';
    }
} else {
    $data['success'] = false;
    $data['message'] = 'Adviser ID not provided.';
}

// Return the response as JSON
echo json_encode($data);
?>
