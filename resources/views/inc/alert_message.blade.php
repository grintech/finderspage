<?php use App\Models\User\UserAuth; ?>
<style>
.alert-login_popup {
  margin-block: 2.5rem;
  padding: 1.25rem;
  display: grid;
  grid-gap: 1.25rem;
  grid-template-columns: max-content auto;
  border-radius: 4px;
  transition: 0.12s ease;
  position: relative;
  overflow: hidden;
  background-color: #000 !important;
  border-left:4px solid #dc7228;
}
.alert-login_popup:before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  mix-blend-mode: soft-light;
  background: linear-gradient(90deg, rgba(255, 255, 255, 0) 30%, white 56%, rgba(2, 0, 36, 0.1) 82%);
  z-index: 1;
}
.alert-login_popup .icon, .alert-login_popup .content {
  z-index: 2;
}
.alert-login_popup .icon {
  line-height: 1;
}
.alert-login_popup .title {
  font-weight: 700;
  margin-bottom: 0.75rem;
  color: #fff;
}
/*.alert-login_popup .content {*/
/*  max-width: 60ch;*/
/*}*/

.alert-login_popup.alert--info .icon {
  color: #fff;
}
.alert-login_popup .progress-bar{margin-top: 10px;}



@media (max-width: 767px) {
    .alert {
        grid-template-columns: auto;
        padding: 1rem;
        grid-gap: 0.75rem;
        .icon {
            font-size: 1.5rem;
        }
        .title {
            margin-bottom: 0.5rem;
        }
    }
}

</style>
<?php  $user = UserAuth::getLoginUser(); ?>
        {{-- @if ($user->free_listing == 1)
        <div id="alertContainer" class="alert-login_popup alert--info">
            <i class="fa fa-info-circle fa-2xl icon"></i> 
            <div class="content">
                <div class="title">Your first paid listing will be free of charge as a thank you for joining FindersPage.</div>
                <div id="progressBar" class="progress-bar" style="width:100%;height: 7px; background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, rgba(205, 89, 8, 1) 100%);"></div>
            </div>
            
        </div>
            
        @endif --}}
