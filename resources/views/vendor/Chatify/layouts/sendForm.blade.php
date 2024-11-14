<?php 
    use App\Models\Setting;
?>

@if(Setting::get_setting("messages_option", $id) == 1 ||  Setting::get_setting("messages_option", $id) == "")
<div class="messenger-sendCard">
    <span class="block_message" dataurl='{{Setting::get_setting("messages_option", $id)}}'></span>
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <label><span class="fas fa-paperclip"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label>
        <button class="emoji-button"><span class="fas fa-smile"></span></button>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane"></span></button>
    </form>
</div>
@else
<div class="messenger-sendCard" dataurl='{{Setting::get_setting("messages_option", $id)}}'>
    <span class="message_off">This user is currently unavailable and cannot receive messages at this time. Please try again when their messaging is enabled.</span>
</div>
@endif
