<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Book of Whos - Upload</title>
    <link rel="icon" type="image/png" href="assets/icon.png">
</head>


<body>

    <form action="uploadphoto.php" method="post" enctype="multipart/form-data">
        <div class="Bigmenu">
            <div class="quicknav" id="bigzone">
                <label for="image" style="border: rgb(100, 100, 100) 1px solid; padding: 80px"><input type="file" id="image" name="image" accept="image/jpeg , image/png, image/gif, image/webp" hidden>
                    <img src="assets/Upload.png"> </img> <br>
                    <span style="font-size: 20px; font-weight:bold">Upload a image here</span>
                    <br> <span>Supports jpg, png, gif and webp files up to 100MB</span>
                </label>

            </div>
            <ul id="filelist"></ul>
            <input type="submit" class="flexbutton" name="submit" value="Upload">
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
            //byt ut
            for (const file of files) {
                const item = document.createElement("li");
                const div = document.createElement("div");
                div.className = "container";
                item.appendChild(div);


                if (file.type.startsWith("image/")) {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.alt = file.name;
                    img.style.width = "150px";
                    img.style.height = "auto";
                    img.style.display = "block";
                    img.style.marginBottom = "8px";

                    div.appendChild(img);
                }

                const details = document.createElement("p");
                details.textContent = `${file.name} (${Math.round(file.size / 1024)} KB)`;

                div.appendChild(details);
                fileList.append(div);
            }
        }
    </script>
</body>

</html>