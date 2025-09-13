<html>
    <head>
        <script>
            window.opener.parent.postMessage("{{ $token }}", "http://localhost:3000/account");
            window.close()
        </script>
    </head>
    <body></body>
</html>