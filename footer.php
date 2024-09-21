

<footer>
        <div class="wave footer"></div>
        <div class="container margin_60_40 fix_mobile">
            <hr>
            <div class="row add_bottom_25">
                <div class="col-lg-6">
                    <ul class="footer-selector clearfix">
                        <li>
                            <div class="styled-select lang-selector">
                                <select>
                                    <option value="Türkce" selected>Türkçe</option>
                                    <option value="English">English</option>
                                    <option value="Spanish">Spanish</option>
                                    <option value="Russian">Russian</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="styled-select currency-selector">
                                <select>
                                    <option value="Türk Lirası" selected>Türk Lirası</option>
                                    <option value="Euro">Euro</option>
                                </select>
                            </div>
                        </li>
                        <li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/yavuzlar.png" alt="" width="150" height="35" class="lazy"></li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="additional_links">
                        <li><a href="#0">Terms and conditions</a></li>
                        <li><a href="#0">Privacy</a></li>
                        <li><span>© Lezzet Sepeti</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div id="toTop"></div>

<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">
    <div class="modal_header">
        <h3>Giriş Yap</h3>
    </div>
    <form method="post" action="system/function.php">
        <div class="sign-in-wrapper">
            <div class="form-group">
                <label>Kullanıcı Adı</label>
                <input type="text" class="form-control" name="username" id="username">
                <i class="icon_mail_alt"></i>
            </div>
            <div class="form-group">
                <label>Şifre</label>
                <input type="password" class="form-control" name="password" id="password" value="">
                <i class="icon_lock_alt"></i>
            </div>
            <div class="text-center">
                <input type="submit" value="Giriş Yap" class="btn_1 full-width mb_5">
                Hesabın Yokmu? <a href="register.php">Kayıt Ol</a>
            </div>
        </div>
        <input type="hidden" name="islem" value="login">
    </form>
</div>

<script src="js/common_scripts.min.js"></script>
<script src="js/common_func.js"></script>
<script src="assets/validate.js"></script>

<!-- TYPE EFFECT -->
    <script src="js/typed.min.js"></script>
    <script>
        var typed = new Typed('.element', {
          strings: ["Sıcak", "Taze", "Hızlı"],
          startDelay: 10,
          loop: true,
          backDelay: 2000,
          typeSpeed: 50
        });
    </script>

<script>
function initMap() {
    var input = document.getElementById('autocomplete');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    });
}
</script>
<script>
    document.getElementById('gpsButton').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});

function showPosition(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;

    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json&addressdetails=1`)
        .then(response => response.json())
        .then(data => {
            if (data.address) {
                const road = data.address.road || '';
                const suburb = data.address.suburb || '';
                const town = data.address.town || '';
                const province = data.address.province || '';
                const postcode = data.address.postcode || '';

                const formattedAddress = `${suburb ? suburb + ', ' : ''}${road ? road + ', ' : ''}${postcode ? postcode + ' ' : ''}${town ? town + ' ' : ''}${province ? province : ''}`;
                document.getElementById('autocomplete').value = formattedAddress.trim();
            } else {
                alert('Address not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching the address:', error);
        });
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
</script>
<script>
$(document).ready(function() {
    $('#addToBasketModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var foodId = button.data('food-id');
        var modal = $(this);
        modal.find('#food_id').val(foodId);
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>