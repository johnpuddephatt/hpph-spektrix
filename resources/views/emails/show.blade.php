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
</style>
<div>

    <button
        onclick="document.querySelector('#iframe').style.height = '6000px';document.querySelector('#iframe').style.width = '100%';">Full
        width
    </button>

    <button
        onclick="document.querySelector('#iframe').style.height = '6000px';document.querySelector('#iframe').style.width = '820px';">Desktop
        size</button>

    <button
        onclick="document.querySelector('#iframe').style.height = '640px';document.querySelector('#iframe').style.width = '400px';">Phone
        size</button>

    <button onclick="navigator.clipboard.writeText(document.getElementById('iframe').srcdoc)">Copy
        code</button>

</div>

<textarea style="width: 100%; height: 100vh">{{ $email_content_plain }}</textarea>

<iframe class="mx-auto block" frameborder="0" id="iframe" style="width:100%; height: 7000px;"
    srcdoc="<body style='margin: 0'>{{ $email_content }}</body>"></iframe>
