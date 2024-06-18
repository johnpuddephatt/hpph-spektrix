<iframe frameborder="0" id="iframe" style="width:800px; height: 700px;" srcdoc="{{ $email_content }}"></iframe>
<button onclick="navigator.clipboard.writeText(document.getElementById('iframe').srcdoc)">Copy
    code</button>
