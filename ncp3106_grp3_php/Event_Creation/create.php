<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$event_name = "";
$event_description = "";
$event_type = "";
$date = "";
$start_time = "";
$end_time = "";
$registration_fee = "";
$venue = "";
$oic = "";
$event_name_err = "";
$event_description_err = "";
$event_type_err = "";
$date_err = "";
$start_time_err = "";
$end_time_err = "";
$registration_fee_err = "";
$venue_err = "";
$oic_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Validate event name
    $input_event_name = trim($_POST["event_name"]);
    if (empty($input_event_name)) {
        $event_name_err = "Please enter a name.";
    } else {
        $event_name = $input_event_name;
    }
    //Validate event description
    $input_event_description = trim($_POST["event_description"]);
    if (empty($input_event_description)) {
        $event_description_err = "Please enter a event_description.";
    } else {
        $event_description = $input_event_description;
    }
    //Validate event type
    $input_event_type = trim($_POST["event_type"]);
    if (empty($input_event_type)) {
        $event_type_err = "Please enter a event_type.";
    } else {
        $event_type = $input_event_type;
    }

    //Validate event date
    $input_date = trim($_POST["date"]);
    if (empty($input_date)) {
        $date_err = "Please enter a valid event date";
    } else {
        $date = $input_date;
    }

    //Validate start_time.
    $input_start_time = trim($_POST["start_time"]);
    if (empty($input_start_time)) {
        $start_time_err = "Please enter a start_time.";
    } else {
        $start_time = $input_start_time;
    }

    // Validate end time.
    $input_end_time = trim($_POST["end_time"]);
    if (empty($input_end_time)) {
        $end_time_err = "Please enter the end_time amount.";
    } else {
        $end_time = $input_end_time;
    }

    // Validate registration fee.
    $input_registration_fee = trim($_POST["registration_fee"]);
    if (empty($input_registration_fee)) {
        $registration_fee_err = "Please enter an registration_fee.";
    } else {
        $registration_fee = $input_registration_fee;
    }

    // Validate venue.
    $input_venue = trim($_POST["venue"]);
    if (empty($input_venue)) {
        $venue_err = "Please enter the venue amount.";
    } else {
        $venue = $input_venue;
    }

    // Validate oic.
    $input_oic = trim($_POST["oic"]);
    if (empty($input_oic)) {
        $oic_err = "Please enter an oic.";
    } else {
        $oic = $input_oic;
    }

    // Check input errors before inserting in database
    if (empty($event_name_err) && empty($event_description_err) && empty($event_type_err) && empty($date_err) && empty($start_time_err) && empty($end_time_err) && empty($registration_fee_err) && empty($venue_err) && empty($oic_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO event_info (event_name, event_description, event_type, date, start_time, end_time, registration_fee, venue, oic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssss", $param_event_name, $param_event_description, $param_event_type, $param_date, $param_start_time, $param_end_time, $param_registration_fee, $param_venue, $param_oic);

            // Set parameters
            $param_event_name = $event_name;
            $param_event_description = $event_description;
            $param_event_type = $event_type;
            $param_date = $date;
            $param_start_time = $start_time;
            $param_end_time = $end_time;
            $param_registration_fee = $registration_fee;
            $param_venue = $venue;
            $param_oic = $oic;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: create.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
// END OF PHP PART
// START OF HTML PART
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }     
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        display: none;
      }
    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="index.php"><button class="btn btn-danger">Back</button></a>
                    <h2 class="mt-5">Registration </h2>
                    <p>Fill the form</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Event_Name</label>
                            <input type="text" name="event_name" class="form-control <?php echo (!empty($event_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_name; ?>">
                            <span class="invalid-feedback"><?php echo $event_name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Event Description</label>
                            <input type="text" name="event_description" class="form-control <?php echo (!empty($event_description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_description; ?>">
                            <span class="invalid-feedback"><?php echo $event_description_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Event Type</label>
                            <input type="text" name="event_type" class="form-control <?php echo (!empty($event_type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_type; ?>">
                            <span class="invalid-feedback"><?php echo $event_type_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Event Date</label>
                            <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" name="start_time" class="form-control <?php echo (!empty($start_time_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $start_time; ?>">
                            <span class="invalid-feedback"><?php echo $start_time_err; ?></span>
                            </div>
                        <div class="from-group">
                            <label>End Time</label>
                            <input type="time" name="end_time" class="form-control <?php echo (!empty($end_time_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $end_time; ?>">
                            <span class="invalid-feedback"><?php echo $end_time_err; ?></span>

                        </div>
                        <div class="form-group">
                            <label>Registration Fee</label>
                            <input type="number" name="registration_fee" class="form-control <?php echo (!empty($registration_fee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $registration_fee; ?>">
                            <span class="invalid-feedback"><?php echo $registration_fee_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Venue</label>
                            <input type="text" name="venue" class="form-control <?php echo (!empty($venue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $venue; ?>">
                            <span class="invalid-feedback"><?php echo $venue_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Oic</label>
                            <input type="text" name="oic" class="form-control <?php echo (!empty($oic_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $oic; ?>">
                            <span class="invalid-feedback"><?php echo $oic_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="create.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
