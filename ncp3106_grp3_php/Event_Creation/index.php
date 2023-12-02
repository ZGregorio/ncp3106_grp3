<?php
    require_once "../config.php";

    $search = "";
    $input_search = "";
    $search_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once '../config.php';

        $input_search = trim($_POST["search"]);
        $search = $input_search;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Event list</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 900px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <form method="post">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" name="search" class="form-control <?php echo (!empty($search_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $search?>"/>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <a href="create.php"><button class="btn btn-primary">Create</button></a>
            <a href="delete.php"><button class="btn btn-danger">Delete</button></a>
            <?php
            if (!empty($search)) {
                $sql = "SELECT * FROM event_info WHERE event_name LIKE ?";

                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("s", $param_search);
                    $param_search = "%" . $search  . "%";
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                    } else {
                        echo "search failed";
                    }
                }
                $stmt->close();
            } else {
                $sql = "SELECT * FROM event_info";
                if ($stmt = $mysqli->prepare($sql)) {
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                    } else {
                        echo "search failed";
                    }
                }
                $stmt->close();
            }

            if (!empty($result)) {
                if($result->num_rows > 0) {
                    echo '<table class="table table-bordered table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>event_name</th>";
                    echo "<th>event_description</th>";
                    echo "<th>date</th>";
                    echo "<th>start_time</th>";
                    echo "<th>end_time</th>";
                    echo "<th>registration_fee</th>";
                    echo "<th>venue</th>";
                    echo "<th>oic</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($rows = $result->fetch_array()) {
                        echo "<tr class='position-relative'>";
                        echo "<td><a class='stretched-link' href='edit.php?id=".$rows['event_id']."'>" . $rows['event_id'] . "</a></td>";
                        echo "<td>" . $rows['event_name'] . "</td>";
                        echo "<td>" . $rows['event_description'] . "</td>";
                        echo "<td>" . $rows['date'] . "</td>";
                        echo "<td>" . $rows['start_time'] . "</td>";
                        echo "<td>" . $rows['end_time'] . "</td>";
                        echo "<td>" . $rows['registration_fee'] . "</td>";
                        echo "<td>" . $rows['venue'] . "</td>";
                        echo "<td>" . $rows['oic'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    // Free result set
                    $result->free();

                } else {
                    //error message here if $result doesnt have rows
                    echo "no rows found";
                }
            } else {
                // error message here if we didnt get a $result
                echo "no results found";
            }
            ?>
        </div>
    </div>
</body>
                
