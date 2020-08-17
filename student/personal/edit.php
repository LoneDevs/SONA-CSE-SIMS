<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Edit Personal Info</title>

    <?php

    include '../../inc/style.inc.php';
    ?>


</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/student/personal">Personal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <br>
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <h4>Edit Personal Info </h4>
            <?php

            require '../../cleaninput.php';
            require 'process.php';
            require 'sessionmanager.php';
            require '../csrf.php';

            session_start();
            if (!isset($_SESSION['admnno'])) {
                header("Location: ../login.php");
            }

            if (empty($_SESSION['key']))
                $_SESSION['key'] = getKey();

            $csrf = getToken($_SESSION['key']);

            sessionTimer();

            $personal_info = fetchStudentPersonalInfo($_SESSION["admnno"]);

            ?>


            <?php
            if (isset($_POST['submit'])) {
                if (!hash_equals($csrf, $_POST['csrf'])) {
                    csrfError();
                    die();
                }
                foreach ($_POST as $key => $value) {
                    $_POST[$key] = cleanInput($value);
                }
                if ($_POST['filled'] == false) {
                    // INSERT Details
                    $insertMsg = insertStudentPersonalInfo($_POST, $_SESSION['admnno']);
                    if (strcmp($insertMsg, 'success') == 0) {
                        echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                        header("Location: index.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert"> Error ! ' . $insertMsg . ' </div>';
                    }
                } else {
                    // UPDATE Details 
                    $updateMsg = updateStudentPersonalInfo($_POST, $_SESSION['admnno']);
                    if (strcmp($updateMsg, 'success') == 0) {
                        echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                        header("Location: index.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert"> Error ! ' . $updateMsg . ' </div>';
                        //echo $msg;
                    }
                }
            } else {
            }

            ?>
            <form action="" method="post" id="personalForm">
                <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                <input type="hidden" name="filled" value="<?php echo $personal_info['filled'] ?>">
                <div class="form-group">
                    <label for="">Register Number : </label>
                    <input type="text" name="reg_no" id="" class="form-control" value='<?php echo $personal_info['reg_no'] ?>' placeholder="" aria-describedby="helpId">
                </div>
                <!-- Default value to be set  -->
                <input type="hidden" name="section_hid" value="<?php echo $personal_info['section'] ?>" id="sectionVal">
                <div class="form-group">
                    <label for="">Section : </label>
                    <select class="form-control" name="section" id="">
                        <option value="A" id="A">A</option>
                        <option value="B" id="B">B</option>
                        <option value="C" id="C">C</option>
                        <option value="D" id="D">D</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">First Name : </label>
                    <input type="text" name="first_name" id="" class="form-control" value='<?php echo $personal_info['first_name'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Last Name : </label>
                    <input type="text" name="last_name" id="" class="form-control" value='<?php echo $personal_info['last_name'] ?>' placeholder="" aria-describedby="helpId">
                </div>
                <!-- Default value to be set  -->
                <input type="hidden" id="dob_hid" value="<?php echo $personal_info['dob'] ?>">
                <div class="form-group">
                    <label for="">DOB : </label>
                    <input type="date" name="dob" id="dob">
                </div>

                <div class="form-group">
                    <label for="">Age : </label>
                    <input type="text" name="age" id="" class="form-control" value='<?php echo $personal_info['age'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Height ( In cm) : </label>
                    <input type="text" name="height_cm" id="" class="form-control" value='<?php echo $personal_info['height_cm'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Weight ( In Kg) : </label>
                    <input type="text" name="weight_kg" id="" class="form-control" value='<?php echo $personal_info['weight_kg'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <input type="hidden" id="bloodVal" value="<?php echo $personal_info['blood_group'] ?>">
                <div class="form-group">
                    <label for="">Blood Group : </label>
                    <select class="form-control" name="blood_group" id="">
                        <option value="A +ve" id="A +ve">A +ve</option>
                        <option value="B +ve" id="B +ve">B +ve</option>
                        <option value="O +ve" id="O +ve">O +ve</option>
                        <option value="AB +ve" id="AB +ve">AB +ve</option>
                        <option value="A -ve" id="A -ve">A -ve</option>
                        <option value="B -ve" id="B -ve">B -ve</option>
                        <option value="O -ve" id="O -ve">O -ve</option>
                        <option value="AB -ve" id="AB -ve">AB -ve</option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="">Identification Marks : </label>
                    <textarea class="form-control" name="identification_marks" id="" rows="3"><?php echo $personal_info['identification_marks'] ?></textarea>
                </div>

                <div class="form-group">
                    <label for="">Communication Address : </label>
                    <textarea class="form-control" name="communication_address" id="" rows="3"><?php echo $personal_info['communication_address'] ?></textarea>
                </div>

                <div class="form-group">
                    <label for="">Permanent Address : </label>
                    <textarea class="form-control" name="permanent_address" id="" rows="3"><?php echo $personal_info['permanent_address'] ?></textarea>
                </div>

                <div class="form-group">
                    <label for="">District : </label>
                    <input type="text" name="district" id="" class="form-control" value='<?php echo $personal_info['district'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">State : </label>
                    <input type="text" name="state" id="" class="form-control" value='<?php echo $personal_info['state'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Country : </label>
                    <input type="text" name="country" id="" class="form-control" value='<?php echo $personal_info['country'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Pincode : </label>
                    <input type="text" name="pincode" id="" class="form-control" value='<?php echo $personal_info['pincode'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Phone Number : </label>
                    <input type="text" name="student_phone" id="" class="form-control" value='<?php echo $personal_info['student_phone'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Mother's phone number : </label>
                    <input type="text" name="mother_phone" id="" class="form-control" value='<?php echo $personal_info['mother_phone'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Father's phone number : </label>
                    <input type="text" name="father_phone" id="" class="form-control" value='<?php echo $personal_info['father_phone'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Residential phone number : </label>
                    <input type="text" name="residential_phone" id="" class="form-control" value='<?php echo $personal_info['residential_phone'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <input type="hidden" id="hosteller_hid" value="<?php echo $personal_info['hosteller'] ?>">
                <div class="form-group">
                    <label for="">Hosteller ? : </label>
                    <select class="form-control" name="hosteller" onchange="hostellerFields(this.value)" id="">
                        <option value="Yes" id="yes">Yes</option>
                        <option value="No" id="no">No</option>
                    </select>
                </div>
                <br>
                <hr>
                <div id="hosteller-details" style="display: none;">

                    <div class="form-group">
                        <label for="">Local Guardian Name : </label>
                        <input type="text" name="local_guardian_name" id="local_guardian_name" class="form-control" value='<?php echo $personal_info['local_guardian_name'] ?>' placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="">Local Guardian number : </label>
                        <input type="text" name="local_guardian_phone" id="local_guardian_phone" class="form-control" value='<?php echo $personal_info['local_guardian_phone'] ?>' placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="">Local Guardian Address : </label>
                        <textarea class="form-control" name="local_guardian_address" id="local_guardian_address" rows="3"> <?php echo $personal_info['local_guardian_address'] ?> </textarea>
                    </div>
                </div>


                <div id="dayscholar-details" style="display: block;">
                    <div class="form-group">
                        <label for="">Mode of Transport : </label>
                        <input type="text" name="mode_of_transport" id="mode_of_transport" class="form-control" value='<?php echo $personal_info['mode_of_transport'] ?>' placeholder="" aria-describedby="helpId">
                    </div>
                </div>


                <hr>
                <div class="form-group">
                    <label for="">Community : </label>
                    <input type="text" name="community" id="" class="form-control" value='<?php echo $personal_info['community'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Caste : </label>
                    <input type="text" name="caste" id="" class="form-control" value='<?php echo $personal_info['caste'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Religion : </label>
                    <input type="text" name="religion" id="" class="form-control" value='<?php echo $personal_info['religion'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Mother Tongue : </label>
                    <input type="text" name="mother_tongue" id="" class="form-control" value='<?php echo $personal_info['mother_tongue'] ?>' placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">Known Languages : </label>
                    <input type="text" name="known_languages" id="" class="form-control" value='<?php echo $personal_info['known_languages'] ?>' placeholder="" aria-describedby="helpId">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
    <br>

    <?php
    include '../../inc/js.inc.php';
    ?>
    <script>
        document.getElementById("dob").defaultValue = document.getElementById("dob_hid").value; // date default val 
        var sec_val = document.getElementById("sectionVal").value;
        switch (sec_val) {
            case 'A':
                document.getElementById("A").selected = true;
                break;
            case 'B':
                document.getElementById("B").selected = true;
                break;
            case 'C':
                document.getElementById("C").selected = true;
                break;
            case 'D':
                document.getElementById("D").selected = true;
                break;
            default:
                document.getElementById("A").selected = true;
                break;
        }
        var blood_val = document.getElementById("bloodVal").value;
        switch (blood_val) {
            case "A +ve":
                document.getElementById("A +ve").selected = true;
                break;
            case "B +ve":
                document.getElementById("B +ve").selected = true;
                break;
            case "O +ve":
                document.getElementById("O +ve").selected = true;
                break;
            case "AB +ve":
                document.getElementById("AB +ve").selected = true;
                break;
            case "A -ve":
                document.getElementById("A -ve").selected = true;
                break;
            case "B -ve":
                document.getElementById("B -ve").selected = true;
                break;
            case "O -ve":
                document.getElementById("O -ve").selected = true;
                break;
            case "AB -ve":
                document.getElementById("AB -ve").selected = true;
                break;
            default:
                document.getElementById("A +ve").selected = true;
                break;
        }

        var hosteller_val = document.getElementById("hosteller_hid").value;
        switch (hosteller_val) {
            case "Yes":
                document.getElementById("hosteller-details").style.display = 'block';
                document.getElementById("dayscholar-details").style.display = 'none';
                document.getElementById("mode_of_transport").value = "NA";
                document.getElementById("yes").selected = true;
                break;

            default:
                document.getElementById("hosteller-details").style.display = 'none';
                document.getElementById("dayscholar-details").style.display = 'block';
                document.getElementById("local_guardian_name").value = "NA";
                document.getElementById("local_guardian_phone").value = "NA";
                document.getElementById("local_guardian_address").value = "NA";
                document.getElementById("no").selected = true;
                break;
        }

        function hostellerFields(value) {
            if (value === "Yes") {
                document.getElementById("hosteller-details").style.display = 'block';
                document.getElementById("dayscholar-details").style.display = 'none';
                document.getElementById("mode_of_transport").value = "NA";
                document.getElementById("yes").selected = true;

            } else {
                document.getElementById("hosteller-details").style.display = 'none';
                document.getElementById("dayscholar-details").style.display = 'block';
                document.getElementById("local_guardian_name").value = "NA";
                document.getElementById("local_guardian_phone").value = "NA";
                document.getElementById("local_guardian_address").value = "NA";
                document.getElementById("no").selected = true;

            }
            //hostellerFields(document.getElementById("hosteller_hid").value);
        }
    </script>
    <script>
        jQuery.validator.addMethod("exactlength", function(value, element, param) {
            return this.optional(element) || value.length == param;
        }, $.validator.format("Please enter exactly {0} characters."));

        $("#personalForm").validate({
            rules: {
                reg_no: {
                    required: true,
                    number: true,
                    exactlength: 10
                },
                section: {
                    required: true
                },
                first_name: {
                    required: true,
                    number: false,
                    rangelength: [2, 100]
                },
                last_name: {
                    required: true,
                    number: false,
                    rangelength: [1, 100]
                },
                dob: {
                    required: true
                },
                age: {
                    required: true,
                    number: true,
                    range: [16, 40]
                },
                height_cm: {
                    required: true,
                    number: true,
                },
                weight_kg: {
                    required: true,
                    number: true
                },
                identification_marks: {
                    required: true,
                    rangelength: [10, 256]
                },
                communication_address: {
                    required: true,
                    rangelength: [10, 256]
                },
                permanent_address: {
                    required: true,
                    rangelength: [10, 256]
                },
                district: {
                    required: true,
                    rangelength: [2, 150]
                },
                state: {
                    required: true,
                    rangelength: [2, 150]

                },
                country: {
                    required: true,
                    rangelength: [2, 150]

                },
                pincode: {
                    required: true,
                    number: true,
                    rangelength: [5, 15]
                },
                student_phone: {
                    required: true,
                    phoneUS: true
                },
                mother_phone: {
                    phoneUS: true
                },
                father_phone: {
                    phoneUS: true
                },
                community: {
                    required: true,
                    rangelength: [2, 100]
                },
                caste: {
                    required: true,
                    rangelength: [2, 100]
                },
                religion: {
                    required: true,
                    rangelength: [2, 100]
                },
                mother_tongue: {
                    required: true,
                    rangelength: [2, 100]
                },
                known_languages: {
                    required: true,
                    rangelength: [2, 100]

                },
                local_guardian_name: {
                    required: true,
                    rangelength: [2, 100]
                },
                local_guardian_phone: {
                    required: true,
                    rangelength: [2, 100]
                },
                local_guardian_address: {
                    required: true,
                    rangelength: [2, 100]
                },

                mode_of_transport: {
                    required: true,
                    rangelength: [2, 100]
                }
            },
            messages: {
                reg_no: {
                    required: "Reg No cannot be empty !",
                    number: "Enter a valid RegNo ! ",
                    rangelength: "Must be 10 characters in length ! "
                },
                section: {
                    required: "Section is required !"
                },
                first_name: {
                    required: "First name cannot be empty !",
                    number: "Cannot contain numbers ! ",
                    rangelength: "Must be 2 between to 100 characters in length !"
                },
                last_name: {
                    required: "Last name cannot be empty !",
                    number: "Cannot contain numbers ! ",
                    rangelength: "Must be 2 between to 100 characters in length !"
                },
                dob: {
                    required: "DOB cannot be left empty ! ",
                },
                age: {
                    required: "Age cannot be left empty ! ",
                    range: "Must be between 16 and 30"
                },
                height_cm: {
                    required: "Height is required ! ",
                },
                weight_kg: {
                    required: "Weight is required !",
                },
                identification_marks: {
                    required: "Identification marks is required !",
                    rangelength: "Must be 10 to 100 characters in length !"
                },
                communication_address: {
                    required: "Communication Address is required !",
                    rangelength: "Must be 10 to 100 characters in length !"
                },
                permanent_address: {
                    required: "Permanent Address is required !",
                    rangelength: "Must be 10 to 100 characters in length !"
                },
                district: {
                    required: "District is required !",
                    rangelength: "Must be between 2 to 150 characters in length ! "
                },
                state: {
                    required: "State/Province is required !",
                    rangelength: "Must be between 2 to 150 characters in length ! "
                },
                country: {
                    required: "Country is required !",
                    rangelength: "Must be between 2 to 150 characters in length ! "
                },
                pincode: {
                    required: "Pincode is required !",
                    rangelength: "Must be between 5 to 15 characters in length !"
                }
            }
        });
    </script>
</body>

</html>