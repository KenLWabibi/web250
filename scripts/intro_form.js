function createCourseInput(value = '') {
    const container = document.getElementById('courses-container');
    const div = document.createElement('div');
    div.className = 'course-input';

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'courses[]';
    input.placeholder = 'Enter course and reason';
    input.value = value;

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'remove-course-btn';
    removeBtn.textContent = 'Remove';

    // Add click event listener to remove this course input
    removeBtn.addEventListener('click', function () {
        div.remove();
    });

    div.appendChild(input);
    div.appendChild(removeBtn);
    container.appendChild(div);
}

// Add event listener to the "Add Course" button
document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-course-btn');
    if (addBtn) {
        addBtn.addEventListener('click', function () {
            createCourseInput(); // Adds a new blank course input
        });
    }

    // Attach remove event to all existing remove buttons
    document.querySelectorAll('.remove-course-btn').forEach((button) => {
        button.addEventListener('click', function () {
            this.parentElement.remove();
        });
    });
});
