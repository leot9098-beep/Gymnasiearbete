<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Upload</title>
</head>


<body>

    <form action="uploadphoto.php" method="post" enctype="multipart/form-data">
        <div class="Bigmenu">
            <div class="flexnav" id="bigzone">
                <label for="image"><input type="file" id="image" name="image" accept="image/jpeg , image/png, image/gif, image/webp" hidden>
                    <img src="assets/Upload.png" width="300px"> hello</img></label>


            </div> <input type="submit" name="submit" value="Send">
            <ul id="filelist"></ul>
        </div>
    </form>

    <script>
        const zone = document.querySelector("#bigzone");
        const input = document.querySelector("#image");
        const fileList = document.querySelector("#filelist");

        zone.addEventListener("click", () => input.click());

        zone.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                input.click();
            }
        });

        zone.addEventListener("dragover", (event) => {
            event.preventDefault(); // Required to allow dropping
            zone.classList.add("dragover");
        });

        zone.addEventListener("dragleave", () => {
            zone.classList.remove("dragover");
        });

        zone.addEventListener("drop", (event) => {
            event.preventDefault();
            zone.classList.remove("dragover");
            showFiles(event.dataTransfer.files);
        });

        input.addEventListener("change", () => showFiles(input.files));

        function showFiles(files) {
            fileList.replaceChildren();

            for (const file of files) {
                const item = document.createElement("li");
                item.textContent = `${file.name} (${Math.round(file.size / 1024)} KB)`;
                fileList.append(item);
            }
        }
    </script>
</body>

</html>