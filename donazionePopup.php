<!-- donazionePopup.php -->
<div id="donationPopup" class="popup-container">
    <div class="popup-content">
        <button id="closeDonationPopup" class="close-btn">X</button>
        <h2>Fai una Donazione</h2>
        <form id="donationForm" action="javascript:void(0);">
            <label for="donationAmount">Importo della Donazione (€):</label>
            <input type="number" id="donationAmount" name="donationAmount" min="1" required>
            <button type="submit" id="donateBtn" class="donate-btn">Dona Ora</button>
        </form>
    </div>
</div>