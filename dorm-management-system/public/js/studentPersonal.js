document.addEventListener('DOMContentLoaded', function() {
    // По умолчанию показываем новости; можно использовать глобальную переменную successType, переданную из Blade
    showNews();
    if(window.successType === 'profile_updated') {
        showPersonal();
    } else if(window.successType === 'request_updated' || window.successType === 'request_created') {
        openRequestList();
    } else if(window.successType === 'gym_created' || window.successType === 'gym_canceled') {
        showSportsBooking();
    } else if(window.successType === 'change_room_created' || window.successType === 'user_updated') {
        showHousing();
    }
});

document.getElementById("file-upload").addEventListener("change", function () {
    let fileName = this.files[0] ? this.files[0].name : "Не выбрано";
    document.getElementById("file-label").textContent = `📎 ${fileName}`;
});

function cancelSportsForm() {
    document.getElementById('sport').value = '';
    document.getElementById('time').value = '';
}

function showRequestRepair() {
    hideAllSections();
    document.getElementById('repair-list').style.display = 'block';
}

function openRequestDetails(id) {
    document.getElementById('request-list').style.display = 'none';
    document.getElementById('request-details-' + id).style.display = 'block';
}

function closeRequestDetails(id) {
    document.getElementById('request-details-' + id).style.display = 'none';
    document.getElementById('request-list').style.display = 'block';
}

function openRequestList() {
    hideAllSections();
    document.getElementById('request-list').style.display = 'block';
}

function closeRequestList() {
    document.getElementById('request-list').style.display = 'none';
    document.getElementById('repair-list').style.display = 'block';
}

function openRepairModal() {
    document.getElementById('repairModal').style.display = 'flex';
}

function closeRepairModal() {
    document.getElementById('repairModal').style.display = 'none';
}

function openEditModal(id) {
    document.getElementById('edit-modal-' + id).style.display = 'flex';
}

function closeEditModal(id) {
    document.getElementById('edit-modal-' + id).style.display = 'none';
}

function showSportsBooking() {
    hideAllSections();
    document.getElementById('sports-section').style.display = 'block';
}

function hideAllSections() {
    document.getElementById('news-section').style.display = 'none';
    document.getElementById('personal-section').style.display = 'none';
    document.getElementById('housing-section').style.display = 'none';
    document.getElementById('sports-section').style.display = 'none';
    document.getElementById('repair-list').style.display = 'none';
    document.getElementById('request-list').style.display = 'none';
    document.getElementById('repairModal').style.display = 'none';
    // Скрываем все модальные окна редактирования, используя класс "edit-modal"
    document.querySelectorAll('.edit-modal').forEach(modal => {
        modal.style.display = 'none';
    });
}

function showNews() {
    hideAllSections();
    document.getElementById('news-section').style.display = 'block';
    document.getElementById("main-content").style.display = "block";
}

function showPersonal() {
    hideAllSections();
    document.getElementById('personal-section').style.display = 'block';
    document.getElementById("main-content").style.display = "block";
}

function showHousing() {
    hideAllSections();
    document.getElementById('housing-section').style.display = 'block';
    document.getElementById("main-content").style.display = "block";
}

function openPasswordModal() {
    document.getElementById('passwordModal').style.display = 'flex';
}

function closePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
}

function openChangeRoomModal() {
    document.getElementById('changeRoomModal').style.display = 'flex';
}

function closeChangeRoomModal() {
    document.getElementById('changeRoomModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const buildingSelect = document.getElementById('buildingSelect');
    const floorSelect = document.getElementById('floorSelect');
    const roomSelect = document.getElementById('roomSelect');

    buildingSelect.addEventListener('change', async function() {
        const buildingId = this.value;
        floorSelect.disabled = true;
        roomSelect.disabled = true;
        floorSelect.innerHTML = '<option>Загрузка...</option>';
        roomSelect.innerHTML = '<option>Сначала выберите этаж</option>';

        if (!buildingId) return;

        const response = await fetch(`/floors/${buildingId}`);
        const floors = await response.json();

        if (!floors || floors.length === 0) {
            floorSelect.innerHTML = '<option>Нет доступных этажей</option>';
            return;
        }

        floorSelect.innerHTML = '<option value="">Выберите этаж</option>';
        floors.forEach(f => {
            floorSelect.innerHTML += `<option value="${f}">${f}</option>`;
        });
        floorSelect.disabled = false;
    });

    floorSelect.addEventListener('change', async function() {
        const buildingId = buildingSelect.value;
        const floor = this.value;
        roomSelect.disabled = true;
        roomSelect.innerHTML = '<option>Загрузка...</option>';

        if (!floor) return;

        const response = await fetch(`/rooms/${buildingId}/${floor}`);
        const rooms = await response.json();

        if (!rooms || rooms.length === 0) {
            roomSelect.innerHTML = '<option>Нет доступных комнат</option>';
            return;
        }

        roomSelect.innerHTML = '<option value="">Выберите комнату</option>';
        rooms.forEach(r => {
            roomSelect.innerHTML += `<option value="${r.id}">${r.room_number}</option>`;
        });
        roomSelect.disabled = false;
    });
});
