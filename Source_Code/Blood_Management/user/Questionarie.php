<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
    <title>Questionnaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #dddddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .declaration {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Health Assessment Questionnaire</h1>
    <form action="#">
        <table>
            <tr>
                <th>Question</th>
                <th>Yes</th>
                <th>No</th>
            </tr>
            <tr>
                <td>1.1 Are you feeling well and in good health today?</td>
                <td><input type="radio" name="q1_1" value="Yes"></td>
                <td><input type="radio" name="q1_1" value="No"></td>
            </tr>
            <tr>
                <td>1.2 In the last 4 hours, have you had a meal or snack?</td>
                <td><input type="radio" name="q1_2" value="Yes"></td>
                <td><input type="radio" name="q1_2" value="No"></td>
            </tr>
            <tr>
                <td>1.3 Have you already given blood in the last 16 weeks?</td>
                <td><input type="radio" name="q1_3" value="Yes"></td>
                <td><input type="radio" name="q1_3" value="No"></td>
            </tr>
            <tr>
                <td>1.4 Have you got a chesty cough, sore throat, or active cold sore?</td>
                <td><input type="radio" name="q1_4" value="Yes"></td>
                <td><input type="radio" name="q1_4" value="No"></td>
            </tr>
            <tr>
                <td>1.5 Are you pregnant or breastfeeding?</td>
                <td><input type="radio" name="q1_5" value="Yes"></td>
                <td><input type="radio" name="q1_5" value="No"></td>
            </tr>
            <tr>
                <td>1.6 Do you have or have you ever had:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Chest pains, heart disease/surgery or a stroke?</td>
                <td><input type="radio" name="q1_6_a" value="Yes"></td>
                <td><input type="radio" name="q1_6_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Lung disease, tuberculosis or asthma?</td>
                <td><input type="radio" name="q1_6_b" value="Yes"></td>
                <td><input type="radio" name="q1_6_b" value="No"></td>
            </tr>
            <tr>
                <td>c) Cancer, a blood disease, an abnormal bleeding disorder, or a bleeding gastric ulcer or duodenal ulcer?</td>
                <td><input type="radio" name="q1_6_c" value="Yes"></td>
                <td><input type="radio" name="q1_6_c" value="No"></td>
            </tr>
            <tr>
                <td>d) Diabetes, thyroid disease, kidney disease, epilepsy (fits)?</td>
                <td><input type="radio" name="q1_6_d" value="Yes"></td>
                <td><input type="radio" name="q1_6_d" value="No"></td>
            </tr>
            <tr>
                <td>e) Chagas disease, babesiosis, HTLVI/II or any other chronic infectious disease?</td>
                <td><input type="radio" name="q1_6_e" value="Yes"></td>
                <td><input type="radio" name="q1_6_e" value="No"></td>
            </tr>
            <tr>
                <td>1.7 In the last 7 days, have you seen a doctor, dentist, or any other healthcare professional or are you waiting to see one (except for routine screening appointments)?</td>
                <td><input type="radio" name="q1_7" value="Yes"></td>
                <td><input type="radio" name="q1_7" value="No"></td>
            </tr>
            <tr>
                <td>1.8 In the past 12 months:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Have you been ill, received any treatment or taken any medication?</td>
                <td><input type="radio" name="q1_8_a" value="Yes"></td>
                <td><input type="radio" name="q1_8_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Have you been under a doctor’s care, undergone surgery, or a diagnostic procedure, suffered a major illness, or been involved in a serious accident?</td>
                <td><input type="radio" name="q1_8_b" value="Yes"></td>
                <td><input type="radio" name="q1_8_b" value="No"></td>
            </tr>
            <tr>
                <td>1.9 Have you ever had yellow jaundice (excluding jaundice at birth), hepatitis or liver disease or a positive test for hepatitis?</td>
                <td><input type="radio" name="q1_9" value="Yes"></td>
                <td><input type="radio" name="q1_9" value="No"></td>
            </tr>
            <tr>
                <td>a) In the past 12 months, have you had close contact with a person with yellow jaundice or viral hepatitis, or have you been given a hepatitis B vaccination?</td>
                <td><input type="radio" name="q1_9_a" value="Yes"></td>
                <td><input type="radio" name="q1_9_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Have you ever had hepatitis B or hepatitis C or think you may have hepatitis now?</td>
                <td><input type="radio" name="q1_9_b" value="Yes"></td>
                <td><input type="radio" name="q1_9_b" value="No"></td>
            </tr>
            <tr>
                <td>c) In the past 12 months, have you been tattooed, had ear or body piercing, acupuncture, circumcision or scarification, cosmetic treatment?</td>
                <td><input type="radio" name="q1_9_c" value="Yes"></td>
                <td><input type="radio" name="q1_9_c" value="No"></td>
            </tr>
            <tr>
                <td>1.10 In the past 12 months, have you or your sexual partner received a blood transfusion?</td>
                <td><input type="radio" name="q1_10" value="Yes"></td>
                <td><input type="radio" name="q1_10" value="No"></td>
            </tr>
            <tr>
                <td>1.11 Have you or your sexual partner been treated with human or animal blood products or clotting factors?</td>
                <td><input type="radio" name="q1_11" value="Yes"></td>
                <td><input type="radio" name="q1_11" value="No"></td>
            </tr>
            <tr>
                <td>1.12 Have you ever had injections of human pituitary growth hormone, pituitary gonadotrophin (fertility medicine) or seen a neurosurgeon or neurologist?</td>
                <td><input type="radio" name="q1_12" value="Yes"></td>
                <td><input type="radio" name="q1_12" value="No"></td>
            </tr>
            <tr>
                <td>1.13 Have you or close relatives had an unexplained neurological condition or been diagnosed with Creutzfeldt-Jacob Disease or ‘mad cow disease’?</td>
                <td><input type="radio" name="q1_13" value="Yes"></td>
                <td><input type="radio" name="q1_13" value="No"></td>
            </tr>
            <tr>
                <td>1.14 Have you:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Ever had malaria or an unexplained fever associated with travel?</td>
                <td><input type="radio" name="q1_14_a" value="Yes"></td>
                <td><input type="radio" name="q1_14_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Visited any malarial area in the last 12 months?</td>
                <td><input type="radio" name="q1_14_b" value="Yes"></td>
                <td><input type="radio" name="q1_14_b" value="No"></td>
            </tr>
            <tr>
                <td>1.15 When did you last travel to another region or _________________ country (in months / years)?</td>
                <td><input type="text" name="q1_15"></td>
                <td></td>
            </tr>
        </table>

        <h1>Risk Assessment Questionnaire</h1>
        <table>
            <tr>
                <th>Question</th>
                <th>Yes</th>
                <th>No</th>
            </tr>
            <tr>
                <td>2.1 Is your reason for donating blood to undergo an HIV test?</td>
                <td><input type="radio" name="q2_1" value="Yes"></td>
                <td><input type="radio" name="q2_1" value="No"></td>
            </tr>
            <tr>
                <td>2.2 Have you ever been tested for HIV?</td>
                <td><input type="radio" name="q2_2" value="Yes"></td>
                <td><input type="radio" name="q2_2" value="No"></td>
            </tr>
            <tr>
                <td>2.3 If ‘‘Yes’’ what was the reason? Voluntary Employment Insurance Medical advice Other: <input type="text" name="q2_3"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2.4 Have you ever had casual, oral or anal sex with someone whose background you do not know, with or without a condom?</td>
                <td><input type="radio" name="q2_4" value="Yes"></td>
                <td><input type="radio" name="q2_4" value="No"></td>
            </tr>
            <tr>
                <td>2.5 Have you ever exchanged money, drugs, goods or favours in return for sex?</td>
                <td><input type="radio" name="q2_5" value="Yes"></td>
                <td><input type="radio" name="q2_5" value="No"></td>
            </tr>
            <tr>
                <td>2.6 Have you suffered from a sexually transmitted disease (STD): e.g. syphilis, gonorrhoea, genital herpes, genital ulcer, VD, or ‘drop’?</td>
                <td><input type="radio" name="q2_6" value="Yes"></td>
                <td><input type="radio" name="q2_6" value="No"></td>
            </tr>
            <tr>
                <td>2.7 In the past 12 months:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Has there been any change in your marital status?</td>
                <td><input type="radio" name="q2_7_a" value="Yes"></td>
                <td><input type="radio" name="q2_7_a" value="No"></td>
            </tr>
            <tr>
                <td>b) If sexually active, do you think any of the above questions (2.1-----2.6) may be true for your sexual partner?</td>
                <td><input type="radio" name="q2_7_b" value="Yes"></td>
                <td><input type="radio" name="q2_7_b" value="No"></td>
            </tr>
            <tr>
                <td>c) Have you been a victim of sexual abuse?</td>
                <td><input type="radio" name="q2_7_c" value="Yes"></td>
                <td><input type="radio" name="q2_7_c" value="No"></td>
            </tr>
            <tr>
                <td>2.8 Have you or your sexual partner suffered from night sweats, unintentional weight loss, diarrhea or swollen glands?</td>
                <td><input type="radio" name="q2_8" value="Yes"></td>
                <td><input type="radio" name="q2_8" value="No"></td>
            </tr>
            <tr>
                <td>2.9 Have you ever injected yourself or been injected with illegal or non-prescribed drugs including body-building drugs or cosmetics (even if this was only once or a long time ago)?</td>
                <td><input type="radio" name="q2_9" value="Yes"></td>
                <td><input type="radio" name="q2_9" value="No"></td>
            </tr>
            <tr>
                <td>2.10 Have you been in contact with anyone with an infectious disease or in the last 12 months have you had any immunizations, vaccinations or jabs?</td>
                <td><input type="radio" name="q2_10" value="Yes"></td>
                <td><input type="radio" name="q2_10" value="No"></td>
            </tr>
            <tr>
                <td>2.11 Have you ever been refused as a blood donor, or told not to donate blood?</td>
                <td><input type="radio" name="q2_11" value="Yes"></td>
                <td><input type="radio" name="q2_11" value="No"></td>
            </tr>
        </table>

        <div class="declaration">
            <h1>Declaration</h1>
            <p>
                <label><input type="checkbox" name="declaration[]" value="a"> I confirm that, to the best of my knowledge, I have answered all the questions accurately and I consider my blood safe for transfusion to a patient.</label><br>
                <label><input type="checkbox" name="declaration[]" value="b"> I understand that any wilful misrepresentation of facts could endanger my health or that of patients receiving my blood and may lead to litigation. I am aware that my blood will be screened for, among others, HIV, hepatitis B, hepatitis C and syphilis. I understand that these screening tests are not diagnostic and may yield false-positive results. If any of the tests give a reactive result, I will be contacted using the information I have provided, and offered counselling.</label><br>
                <label><input type="checkbox" name="declaration[]" value="c"> I understand the blood donation process, and I have been counseled regarding the importance of safe blood donation.</label><br>
                <label><input type="checkbox" name="declaration[]" value="d"> I confirm that I am over the age of 18 years.</label><br>
                <label><input type="checkbox" name="declaration[]" value="e"> I undertake that should there be any reason for my blood to be deemed unsafe for use at any stage, I will inform the Blood Transfusion Service.</label>
            </p>
        </div>

        <button type="submit">Submit</button>
		
		   <!-- Last Donation Date field -->
            <div class="form-group">
                <label for="lastDonationDate">Last Donation Date:</label>
                <input type="date" id="lastDonationDate" name="lastDonationDate" class="form-control">
            </div>
<a href='donate_blood.php' style='float: right; width: auto;'>
    <img id='' src='images/back.png' alt='BACK' style='width: 46.5px; height: 46.5px;'>
</a>

    </form>
	
	
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateForm() {
            // Check if any radio button is unchecked
            var uncheckedRadio = document.querySelectorAll('input[type="radio"]:not(:checked)');
            if (uncheckedRadio.length > 0) {
                alert('Please answer all questions.');
                return false; // Prevent form submission
            }

            // Check if any text input is empty (if you have any)
            var textInputs = document.querySelectorAll('input[type="text"]');
            for (var i = 0; i < textInputs.length; i++) {
                if (textInputs[i].value.trim() === '') {
                    alert('Please fill in all fields.');
                    return false; // Prevent form submission
                }
            }

            // Check if at least one declaration checkbox is checked
            var declarationCheckboxes = document.querySelectorAll('input[name="declaration[]"]:checked');
            if (declarationCheckboxes.length === 0) {
                alert('Please agree to the declaration.');
                return false; // Prevent form submission
            }

            return true; // Submit the form if all validations pass
        }
    </script>

    <!-- 
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if the form is submitted

        $servername = "localhost";
        $username = "blood_management";
        $password = "manager";
        $dbname = "blood_management";


        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the form data for insertion
        $donationId = $_POST["lastDonationDate"]; 
        $formData = $_POST;

        // Prepare the INSERT INTO statement
        $sql = "INSERT INTO DonationQuestionnaire (donation_id, ";
        $sql .= implode(", ", array_keys($formData)) . ", lastDonationDate) VALUES (?, ";
        $sql .= str_repeat("?, ", count($formData)) . "?)";

        // Prepare and bind the statement
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters dynamically
            $bindTypes = str_repeat("s", count($formData) + 1); // +1 for donation_id
            $bindParams = array_merge([$bindTypes, $donationId], array_values($formData));
            $stmt->bind_param(...$bindParams);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Form response inserted successfully!');</script>";
            } else {
                echo "<script>alert('Error inserting form response: " . $stmt->error . "');</script>";
            }

            // Close statement
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
        }

        // Close connection
        $conn->close();
    }
    ?>-->
</body>
</html>
	
