// Example: Simple confirmation for delete links (already included in the PHP)
// You can add more complex JS here, like form validation before submission

document.addEventListener('DOMContentLoaded', function() {
    console.log('MediAssist Web JS Loaded');

    // Example: Add client-side validation (can enhance PHP validation)
    const forms = document.querySelectorAll('form'); // Get all forms
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            let formIsValid = true;
            // Find all required inputs within this specific form
            const requiredInputs = form.querySelectorAll('[required]');
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    formIsValid = false;
                    input.style.borderColor = 'red'; // Highlight empty required field
                    // You could add a more visible error message near the input
                } else {
                    input.style.borderColor = '#ccc'; // Reset border color
                }
            });

            if (!formIsValid) {
                console.log('Form validation failed.');
                alert('Please fill in all required fields.'); // Simple alert
                event.preventDefault(); // Stop form submission
            }
        });
    });

    // Reset border color when user starts typing in a field that was marked invalid
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (input.style.borderColor === 'red') {
                 input.style.borderColor = '#ccc';
            }
        });
    });

});

// Note: For features like appointment reminders or real-time updates,
// you would need more advanced JavaScript (AJAX, WebSockets, Service Workers)
// and potentially server-side task scheduling (cron jobs).