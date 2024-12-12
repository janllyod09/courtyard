<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Candidacy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }

        .content {
            margin: 20px;
        }

        .signature {
            margin-top: 30px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="content">
        <h2>CERTIFICATE OF CANDIDACY</h2>
        <p>I, <strong>{{ $name }}</strong>, of legal age and a resident of <strong>{{ $address }}</strong>,
            am filing my candidacy to run for the position of <strong>{{ $selected_position }}</strong> in the upcoming
            election.</p>

        <p>I hereby confirm that I am qualified for the position in compliance with and defined by the Constitution and
            By-Laws (Please check all applicable qualifications).</p>

        <ul>
            <li>Must be of legal age</li>
            <li>Must be in good standing</li>
            <li>Must be an actual resident of Courtyard of Maia Alta for at least six (6) months as certified by the
                association secretary.</li>
            <li>Has not been convicted by final judgement of an offense involving moral turpitude.</li>
            <li>Legitimate Spouse of a member may be a candidate in lieu of the member – in accordance with the
                provisions of Rule 9 of Implementing Rules and Regulations of Magna Carta for Homeowners and Homeowners
                Associations.</li>
        </ul>

        <div class="signature">
            <p>Candidate's Signature Over Printed Name: <strong>{{ $name_formatted }}</strong></p>
            <p>(to be signed during personal filing / candidate presentation)</p>
        </div>
    </div>
</body>

</html>
