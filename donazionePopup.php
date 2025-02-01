<div id="donationPopup" class="donation-popup hidden">
    <div class="donation-popup-content">
        <span id="closeDonationPopup" class="donation-popup-close-btn">×</span>
        <h2>Support Chuck the Beaver!</h2>
        <div id="loaderWheel" class="loader"></div>
        <div id="donationMessage" class="message-container"></div> 
        <form id="donationForm">
            <label for="donationAmount">Donation Amount (€):</label>
            <div class="donation-popup-buttons">
                <button type="button" class="donation-popup-preset" data-value="1">€1</button>
                <button type="button" class="donation-popup-preset" data-value="2">€2</button>
                <button type="button" class="donation-popup-preset" data-value="5">€5</button>
                <button type="button" class="donation-popup-preset" data-value="10">€10</button>
                <button type="button" class="donation-popup-preset" data-value="20">€20</button>
            </div>
            
            <input 
                type="number" 
                id="donationAmount" 
                name="donationAmount" 
 
                placeholder="Enter custom amount" 
                required
            >

            <div class="anonymous-toggle">
                <label for="anonymousToggle">Donate Anonymously:</label>
                <input type="checkbox" id="anonymousToggle" name="anonymousToggle">
            </div>
            
            <button type="submit" class="donation-popup-submit" id="donationSubmit">Donate</button>
        </form>
    </div>
</div>
