<?php
require 'includes/db_connect.php'; // Database connection

$today_date = date("Y-m-d");
$meds_sql = "SELECT name, dosage, frequency, time FROM medications ORDER BY time ASC";
$meds_result = mysqli_query($conn, $meds_sql);

$appts_sql = "SELECT id, appointement_time, type, notes FROM appointments WHERE appointement_date = ? ORDER BY appointement_time ASC";
$stmt_appts = mysqli_prepare($conn, $appts_sql);
if($stmt_appts){
    mysqli_stmt_bind_param($stmt_appts, "s", $today_date);
    mysqli_stmt_execute($stmt_appts);
    $appts_result = mysqli_stmt_get_result($stmt_appts);
} else {
    $appts_result = false; 
}

include 'includes/header.php';
?>

<section class="hero-section">
    <div class="container hero-content">
        <div class="hero-text">
            <h1>Votre Santé,<br>Simplifiée.</h1>
            <p>Gérez vos médicaments, rendez-vous et ordonnances facilement avec MediAssist.</p>
            <a href="#dashboard-cards" class="button-secondary">Voir le Tableau de Bord <i class="fas fa-arrow-down"></i></a>
        </div>
        <div class="hero-image-container">

        <img src="MedAssist2.png" alt="Illustration gestion santé" class="hero-image"> 
        </div>
    </div>
    <div class="hero-background-shape"></div>
</section>

*<div class="main-content-area container" id="dashboard-start"> 

    <div class="quick-actions">
        <h2>Actions Rapides</h2>
        <a href="add_medication.php" class="action-button"><i class="fas fa-pills"></i> Ajouter Médicament</a>
        <a href="add_appointment.php" class="action-button"><i class="fas fa-calendar-plus"></i> Ajouter RDV</a>
        <a href="add_prescription.php" class="action-button"><i class="fas fa-file-prescription"></i> Ajouter Ordonnance</a>
        <a href="add_contact.php" class="action-button"><i class="fas fa-address-book"></i> Ajouter Contact Urg.</a>
    </div>

    <div class="dashboard-grid" id="dashboard-cards">

        <div class="dashboard-card medications">
             <div class="card-header">
                 <h3><i class="fas fa-clock"></i> Programme Médicaments (Aujourd'hui)</h3>
             </div>
             <div class="card-body">
                 <?php if ($meds_result && mysqli_num_rows($meds_result) > 0): ?>
                     <ul>
                         <?php while($med = mysqli_fetch_assoc($meds_result)): ?>
                             <li>
                                <div>
                                     <span class="item-time"><?php echo date("H:i", strtotime($med['time'])); ?></span>
                                     <span class="item-details">
                                         <?php echo htmlspecialchars($med['name']); ?>
                                         <span class="item-dosage">(<?php echo htmlspecialchars($med['dosage']); ?>)</span>
                                     </span>
                                </div>
                             </li>
                         <?php endwhile; ?>
                     </ul>
                 <?php elseif($meds_result): ?>
                     <p class="no-items">Aucun médicament programmé.</p>
                 <?php else: ?>
                      <p class="message error">Erreur de chargement.</p>
                 <?php endif; ?>
                 <?php if($meds_result) mysqli_free_result($meds_result); ?>
             </div>
             <a href="medications.php" class="view-all-link">Voir Tous les Médicaments <i class="fas fa-arrow-right"></i></a>
         </div>

        <div class="dashboard-card appointments">
             <div class="card-header">
                  <h3><i class="fas fa-calendar-day"></i> Rendez-vous (Aujourd'hui)</h3>
             </div>
             <div class="card-body">
                  <?php if ($appts_result && mysqli_num_rows($appts_result) > 0): ?>
                     <ul>
                         <?php while($appt = mysqli_fetch_assoc($appts_result)): ?>
                             <li>
                                 <div>
                                     <span class="item-time"><?php echo date("H:i", strtotime($appt['appointement_time'])); ?></span>
                                     <span class="item-details">
                                         <?php echo htmlspecialchars($appt['type']); ?>
                                         <?php if (!empty($appt['notes'])): ?>
                                             <span class="item-type">- <?php echo substr(htmlspecialchars($appt['notes']), 0, 40) . '...'; ?></span>
                                         <?php endif; ?>
                                     </span>
                                 </div>
                             </li>
                         <?php endwhile; ?>
                     </ul>
                 <?php elseif($appts_result === false): // Check for prepare error ?>
                     <p class="message error">Erreur de chargement des rendez-vous.</p>
                 <?php else: ?>
                     <p class="no-items">Aucun rendez-vous prévu aujourd'hui.</p>
                 <?php endif; ?>
                  <?php if(isset($stmt_appts) && $stmt_appts) mysqli_stmt_close($stmt_appts); ?>
             </div>
              <a href="appointments.php" class="view-all-link">Voir Tous les Rendez-vous <i class="fas fa-arrow-right"></i></a>
         </div>

    </div> 
</div> 


<?php include 'includes/footer.php'; ?>