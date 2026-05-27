<?php
/**
 * Join Page View
 * Contains the membership application form with validation error display.
 * Variables available: $fieldErrors (from layout), $success (from layout)
 */
?>

<section class="section join-section">
  <div class="container join-container">
    <h2 class="section-title text-center">Join <span class="accent">KCSC</span></h2>

    <?php if (!empty($successMsg)): ?>
      <script>
        // Force form reset to clear browser autocomplete cache on success
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('.join-form');
            if (form) form.reset();
        });
      </script>
      <div class="alert alert-success" style="background-color: #00cc66; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        <strong>Success!</strong> <?= htmlspecialchars($successMsg) ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($fieldErrors)): ?>
      <div class="alert alert-error" style="background-color: #ff4444; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; font-weight: bold;">
        <?php foreach ($fieldErrors as $field => $message): ?>
          <div style="margin-bottom: 5px;">⚠ <?= e($message) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form class="join-form" action="<?= url('join.php') ?>" method="POST" enctype="multipart/form-data">
      <?= csrfField() ?>

      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input
          type="text"
          id="fullName"
          name="full_name"
          required
          value="<?= old('full_name') ?>"
          class="<?= isset($fieldErrors['full_name']) ? 'input-error' : '' ?>"
          placeholder="Enter your full name"
        >
        <?php if (isset($fieldErrors['full_name'])): ?>
          <span class="field-error"><?= e($fieldErrors['full_name']) ?></span>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="studentId">KUET Student ID</label>
        <input
          type="text"
          id="studentId"
          name="student_id"
          required
          value="<?= old('student_id') ?>"
          class="<?= isset($fieldErrors['student_id']) ? 'input-error' : '' ?>"
          placeholder="e.g. 2103001"
        >
        <?php if (isset($fieldErrors['student_id'])): ?>
          <span class="field-error"><?= e($fieldErrors['student_id']) ?></span>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="department">Department</label>
        <select
          id="department"
          name="department"
          required
          class="<?= isset($fieldErrors['department']) ? 'input-error' : '' ?>"
        >
          <option value="" disabled <?= old('department') === '' ? 'selected' : '' ?>>Select your department</option>
          <option value="CSE" <?= old('department') === 'CSE' ? 'selected' : '' ?>>Department of Computer Science & Engineering (CSE)</option>
          <option value="EEE" <?= old('department') === 'EEE' ? 'selected' : '' ?>>Department of Electrical & Electronic Engineering (EEE)</option>
          <option value="ECE" <?= old('department') === 'ECE' ? 'selected' : '' ?>>Department of Electronics and Communication Engineering (ECE)</option>
          <option value="BME" <?= old('department') === 'BME' ? 'selected' : '' ?>>Department of Biomedical Engineering (BME)</option>
          <option value="MTE" <?= old('department') === 'MTE' ? 'selected' : '' ?>>Department of Mechatronics Engineering (MTE)</option>
          <option value="CE" <?= old('department') === 'CE' ? 'selected' : '' ?>>Department of Civil Engineering (CE)</option>
          <option value="URP" <?= old('department') === 'URP' ? 'selected' : '' ?>>Department of Urban and Regional Planning (URP)</option>
          <option value="BECM" <?= old('department') === 'BECM' ? 'selected' : '' ?>>Department of Building Engineering & Construction Management (BECM)</option>
          <option value="ME" <?= old('department') === 'ME' ? 'selected' : '' ?>>Department of Mechanical Engineering (ME)</option>
          <option value="IEM" <?= old('department') === 'IEM' ? 'selected' : '' ?>>Department of Industrial Engineering and Management (IEM)</option>
          <option value="MSE" <?= old('department') === 'MSE' ? 'selected' : '' ?>>Department of Materials Science and Engineering (MSE)</option>
          <option value="LE" <?= old('department') === 'LE' ? 'selected' : '' ?>>Department of Leather Engineering (LE)</option>
          <option value="TE" <?= old('department') === 'TE' ? 'selected' : '' ?>>Department of Textile Engineering (TE)</option>
          <option value="ESE" <?= old('department') === 'ESE' ? 'selected' : '' ?>>Department of Energy Science and Engineering (ESE)</option>
          <option value="ChE" <?= old('department') === 'ChE' ? 'selected' : '' ?>>Department of Chemical Engineering (ChE)</option>
          <option value="ARCH" <?= old('department') === 'ARCH' ? 'selected' : '' ?>>Department of Architecture (ARCH)</option>
        </select>
        <?php if (isset($fieldErrors['department'])): ?>
          <span class="field-error"><?= e($fieldErrors['department']) ?></span>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          value="<?= old('email') ?>"
          class="<?= isset($fieldErrors['email']) ? 'input-error' : '' ?>"
          placeholder="you@example.com"
        >
        <?php if (isset($fieldErrors['email'])): ?>
          <span class="field-error"><?= e($fieldErrors['email']) ?></span>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input
          type="tel"
          id="phone"
          name="phone"
          required
          value="<?= old('phone') ?>"
          class="<?= isset($fieldErrors['phone']) ? 'input-error' : '' ?>"
          placeholder="+880 1XXX-XXXXXX"
        >
        <?php if (isset($fieldErrors['phone'])): ?>
          <span class="field-error"><?= e($fieldErrors['phone']) ?></span>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="image">Profile Photo</label>
        <input
          type="file"
          id="image"
          name="image"
          accept="image/*, .heic, .HEIC"
          required
          class="<?= isset($fieldErrors['image']) ? 'input-error' : '' ?>"
        >
        <div id="imagePreviewContainer" style="display:none; margin-top:15px; align-items:center;">
            <img id="imagePreview" src="" alt="Preview" style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:2px solid #00ffcc;">
            <button type="button" id="btnRemoveImage" style="background:transparent; border:none; color:#ff4444; margin-left:15px; cursor:pointer; font-weight:bold; font-size:14px; text-decoration:underline;">Remove Photo</button>
        </div>
        <?php if (isset($fieldErrors['image'])): ?>
          <span class="field-error"><?= e($fieldErrors['image']) ?></span>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label for="interest">Why are you interested in cybersecurity?</label>
        <textarea
          id="interest"
          name="interest"
          rows="5"
          class="<?= isset($fieldErrors['interest']) ? 'input-error' : '' ?>"
          placeholder="Tell us what excites you about cybersecurity..."
        ><?= old('interest') ?></textarea>
        <?php if (isset($fieldErrors['interest'])): ?>
          <span class="field-error"><?= e($fieldErrors['interest']) ?></span>
        <?php endif; ?>
      </div>

      <button type="submit" class="btn-submit">Submit Application</button>
    </form>
  </div>
</section>

<div id="cropperModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.9); overflow:auto; justify-content:center; align-items:center;">
    <div style="background:#111; padding:20px; border-radius:8px; width:90%; max-width:500px; text-align:center;">
        <h3 style="color:#00ffcc; margin-bottom:15px;">Crop Profile Photo</h3>
        <div style="width:100%; height:350px; margin-bottom:15px; background:#000;">
            <img id="cropperImage" style="max-width:100%; max-height:350px; display:block;" src="">
        </div>
        <p id="processingText" style="display:none; color:#ffbd2e; margin-bottom:15px; font-weight:bold;">Processing HEIC image, please wait...</p>
        <div>
            <button type="button" id="btnCancelCrop" style="background:transparent; border:1px solid #ff4444; color:#ff4444; padding:8px 20px; border-radius:5px; cursor:pointer; margin-right:10px;">Cancel</button>
            <button type="button" id="btnConfirmCrop" style="background:#00ffcc; border:none; color:#000; padding:8px 20px; border-radius:5px; cursor:pointer; font-weight:bold;">Crop & Save</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const cropperModal = document.getElementById('cropperModal');
        const cropperImage = document.getElementById('cropperImage');
        const btnCancelCrop = document.getElementById('btnCancelCrop');
        const btnConfirmCrop = document.getElementById('btnConfirmCrop');
        const processingText = document.getElementById('processingText');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const btnRemoveImage = document.getElementById('btnRemoveImage');
        
        // Add hidden input dynamically
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'cropped_image_base64';
        hiddenInput.id = 'cropped_image_base64';
        imageInput.parentNode.appendChild(hiddenInput);

        let cropper = null;

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            cropperModal.style.display = 'flex';
            processingText.style.display = 'none';
            cropperImage.src = '';
            if (cropper) { cropper.destroy(); cropper = null; }

            const fileName = file.name.toLowerCase();
            if (fileName.endsWith('.heic') || file.type === 'image/heic') {
                processingText.style.display = 'block';
                btnConfirmCrop.disabled = true;
                
                heic2any({ blob: file, toType: 'image/jpeg' })
                    .then(function(resultBlob) {
                        const blobToUse = Array.isArray(resultBlob) ? resultBlob[0] : resultBlob;
                        initCropper(URL.createObjectURL(blobToUse));
                    })
                    .catch(function(e) {
                        alert('Error processing HEIC image.');
                        console.error(e);
                        cropperModal.style.display = 'none';
                        imageInput.value = '';
                    });
            } else {
                initCropper(URL.createObjectURL(file));
            }
        });

        function initCropper(url) {
            processingText.style.display = 'none';
            btnConfirmCrop.disabled = false;
            cropperImage.src = url;
            cropper = new Cropper(cropperImage, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                background: false
            });
        }

        btnCancelCrop.addEventListener('click', function() {
            cropperModal.style.display = 'none';
            imageInput.value = '';
            hiddenInput.value = '';
            if (cropper) { cropper.destroy(); cropper = null; }
        });

        btnConfirmCrop.addEventListener('click', function() {
            if (!cropper) return;
            const canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500
            });
            const base64Data = canvas.toDataURL('image/jpeg', 0.9);
            hiddenInput.value = base64Data;
            cropperModal.style.display = 'none';
            
            // Show preview and hide file input
            imagePreview.src = base64Data;
            imagePreviewContainer.style.display = 'flex';
            imageInput.style.display = 'none';
            imageInput.removeAttribute('required'); // Remove required since base64 is set

            if (cropper) { cropper.destroy(); cropper = null; }
        });

        btnRemoveImage.addEventListener('click', function() {
            imageInput.value = '';
            hiddenInput.value = '';
            imagePreview.src = '';
            imagePreviewContainer.style.display = 'none';
            imageInput.style.display = 'block';
            imageInput.setAttribute('required', 'required'); // Re-enable required
        });
    });
</script>
