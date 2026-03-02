<style>
    body {
        margin: 0
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .block {
        display: block;
    }

    .button {
        background-color: #f1f5f9;
        border: none;
        padding: 8px 20px;
        font-weight: 600;
        
        text-align: center;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        border-radius: 8px;
    }

    .dark {
        background-color: #031017;
        color: white;
    }
</style>
<div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">

    <button class="button"
        onclick="document.querySelector('#iframe').style.height = '6000px';document.querySelector('#iframe').style.width = '100%';">Full
        width
    </button>

    <button class="button"
        onclick="document.querySelector('#iframe').style.height = '6000px';document.querySelector('#iframe').style.width = '820px';">Desktop
        size</button>

    <button class="button"
        onclick="document.querySelector('#iframe').style.height = '640px';document.querySelector('#iframe').style.width = '400px';">Phone
        size</button>

    <button class="button  dark" style="margin-left: auto" onclick="navigator.clipboard.writeText(document.getElementById('iframe').srcdoc)">Copy
        code</button>


     <button class="button dark" onclick="navigator.clipboard.writeText(document.getElementById('plaintext').value)">Copy
       plain text</button>


</div>

<textarea id="plaintext" hidden>{{ $email_content_plain }}</textarea>

<iframe class="mx-auto block" frameborder="0" id="iframe" style="width:100%; height: 7000px;"
    srcdoc="<body style='margin: 0'>{{ $email_content }}</body>"></iframe>
