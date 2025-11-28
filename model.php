<div class="container box" style="margin-top:100px;">
  <div class="row box1">
    <div class="col-md-4 col-sm-12 text-start mm text-center">
      <h3 class="mt-10"><strong>START YOUR HELP</strong></h3>
      <h6>"We make a living by what we get, but we make a life by what we give"</h6>
      <img src="<?php echo base_url('/assets/img/btfly.png'); ?>" alt="no img" class="w-full h-auto img1">
    </div>

    <div id="multi-step-form-container" class="mt-10 col-md-8 col-sm-12">
      <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0 flex-wrap">
        <!-- Steps here -->
        <li class="form-stepper-active text-center form-stepper-list" step="1">
            <a class="mx-2 ">
              <span class="form-stepper-circle">
                <span>1</span>
              </span>
            </a>
          </li>
          <!-- Step 2 -->
          <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>2</span>
              </span>
            </a>
          </li>
          <!-- Step 3 -->
          <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>3</span>
              </span>
            </a>
          </li>
          <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>4</span>
              </span>
            </a>
          </li>
      </ul>

      <form id="individualForm" name="individualForm" action="<?= base_url('kanavuhelp/individualform_data') ?>" enctype="multipart/form-data" method="POST" class="row row-cols-1 mx-3">
        <!-- Step 1 Content -->
        <section id="step-1" class="form-step">
          <h2>Basic Details</h2>
          <div class="col-12 my-3">
            <label for="form-select">I am raising fund for:</label>
            <select name="form_select" id="form_select" class="form-control">
              <option value="" selected>--Select--</option>
              <option value="Medical">Medical</option>
              <!-- More options -->
              <option value="Crisis">Crisis</option>
                <option value="Education">Education</option>
                <option value="Emergency">Emergency</option>
                <option value="Events">Events</option>
                <?php foreach ($result as $row) { ?>
                  <option value="<?php echo $row['id']; ?>" <?php echo set_select('form_select', $row['id'], False); ?>>
                    <?php echo $row['raising_fund_for']; ?>
                  </option>
                <?php } ?>
            </select>
          </div>
          <label for="name"></label>
              <input type="text" id="name" name="name" placeholder="Name" required>

              <label for="email"> </label>
              <input type="email" id="email" name="email" placeholder="Mail Id*" required>

              <label for="phone"></label>
              <input type="phone" id="phone" name="phone" placeholder="Phone Number* " required>
            </div>
            <div class="mt-3 primary" style="margin-left:450px;">
              <button id="openModalBtn1" class="button btn-navigate-form-step" type="button"
                step_number="1">Continue</button>
            </div>
          <!-- Continue Button -->
        </section>

        <!-- Step 2, Step 3, and so on -->
      </form>
    </div>
  </div>
</div>
