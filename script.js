document.getElementById('goodsForm').addEventListener('submit', function(event) {
    // Clear previous error messages
    document.getElementById('nameError').textContent = '';
    document.getElementById('emailError').textContent = '';
    document.getElementById('dateError').textContent = '';

    let valid = true;

    // Validate Name
    const name = document.getElementById('name').value;
    const nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(name)) {
        valid = false;
        document.getElementById('nameError').textContent = 'Please enter a valid name (letters and spaces only).';
    }

    // Validate Email
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        valid = false;
        document.getElementById('emailError').textContent = 'Please enter a valid email address.';
    }

    // Validate Date
    const date = document.getElementById('date').value;
    const today = new Date().toISOString().split('T')[0];
    if (date < today) {
        valid = false;
        document.getElementById('dateError').textContent = 'Please select a future date.';
    }

    if (!valid) {
        event.preventDefault();
    }
});
