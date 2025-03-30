

let studentId = 1; // Auto-incrementing ID for demo

    document.getElementById("asb").addEventListener("click", () => {
        var name = prompt("Enter your name:");
        var email = prompt("Enter your email:");
        
        if (name && email) {
            let tableBody = document.getElementById("studentTableBody");

            let row = document.createElement("tr");
            row.innerHTML = `
                <td class="p-3 border text-center">${studentId}</td>
                <td class="p-3 border">${name}</td>
                <td class="p-3 border">${email}</td>
                <td class="p-3 border text-center">
                    <button onclick="updateStudent(this)" class="bg-yellow-500 text-white px-3 py-1 rounded-lg mr-2">Update</button>
                    <button onclick="deleteStudent(this)" class="bg-red-500 text-white px-3 py-1 rounded-lg">Delete</button>
                </td>
            `;

            tableBody.appendChild(row);
            studentId++; // Increment ID
        } else {
            alert("Name and Email cannot be empty!");
        }
    });

    function updateStudent(button) {
        let row = button.parentElement.parentElement;
        let name = prompt("Enter new name:", row.cells[1].textContent);
        let email = prompt("Enter new email:", row.cells[2].textContent);

        if (name && email) {
            row.cells[1].textContent = name;
            row.cells[2].textContent = email;
        } else {
            alert("Update canceled!");
        }
    }

    function deleteStudent(button) {
        if (confirm("Are you sure you want to delete this student?")) {
            button.parentElement.parentElement.remove();
        }
    }

/*
    document.getElementById("searchBtn").addEventListener("click", function () {
        let searchValue = document.getElementById("searchInput").value.trim();
        let rows = document.querySelectorAll("#tableBody tr");
    
        rows.forEach(row => {
            let idCell = row.querySelector("td:first-child"); // Get first <td> (ID column)
            if (idCell) {
                let idText = idCell.textContent.trim();
                if (idText === searchValue || searchValue === "") {
                    row.style.display = ""; // Show row if it matches
                } else {
                    row.style.display = "none"; // Hide row if it doesn’t match
                }
            }
        });
    });
    */

   