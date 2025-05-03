<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediAssist Web</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Your Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Google Font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="top-bar">
        <div class="container">
            <span>Welcome to MediAssist !</span>     
        </div>
    </div>

    <header class="main-header">
        <div class="container">
            <div class="logo-area">
                <a href="index.php" style="text-decoration: none; color: #6f42c1; font-weight: 700; font-size: 1.5rem;">
                </a>
                <a href="index.php">
                    <img src="medicalife.png" alt="MediAssist Logo" id="logo">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Home</a></li> 
                    <li><a href="medications.php">Medications</a></li>
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="prescriptions.php">Prescriptions</a></li>
                    <li><a href="contacts.php">Emergency contacts </a></li>
                </ul>
            </nav>
            <div class="header-actions">
                 <a href="add_medication.php" class="button-primary"><i class="fas fa-plus"></i> Ajouter Médicament</a>
            </div>
        </div>
    </header>

    <main>