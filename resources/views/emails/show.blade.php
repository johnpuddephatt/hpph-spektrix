<iframe frameborder="0" id="iframe" style="width:900px; height: 700px;" srcdoc="{{ $email_content }}"></iframe>
<button onclick="navigator.clipboard.writeText(document.getElementById('iframe').srcdoc)">Copy
    code</button>

<button
    onclick="document.querySelector('#iframe').style.height = '700px';document.querySelector('#iframe').style.width = '900px';">Desktop
    size</button>

<button
    onclick="document.querySelector('#iframe').style.height = '640px';document.querySelector('#iframe').style.width = '400px';">Phone
    size</button>
