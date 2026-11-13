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
                <label for="image" style="border: rgb(100, 100, 100) 1px solid; width: 100%; padding: 180px 0px 180px 0px;"><input type="file" id="image" name="image" accept="image/jpeg , image/png, image/gif, image/webp" hidden>
                    <img src="assets/Upload.png"> </img> <br>
                    <span style="font-size: 20px; font-weight:bold">Upload a image here</span>
                    <br> <span>Supports jpg, png, gif and webp files up to 100MB</span>

                </label>

            </div>
            <ul id="filelist"></ul>
            <ul id="filelist"></ul>
            <div id="uploaddetails">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="vote for a map">


                <label for="description">Description:</label>
                <input id="desciption" name="description" placeholder="select a hero"></input>


                <label for="tag-input">Tags</label>

                <div id="tag-box">
                    <div id="tags"></div>
                    <input
                        id="tag-input"
                        type="text"
                        placeholder="Ban moira and ana"
                        autocomplete="off">
                </div>


                <ul id="suggestions"></ul>

                <input type="submit" class="appear" class="flexbutton" name="submit" value="Upload" hidden>

            </div>
            <script>
                /* const label = document.createElement("label");
                label.htmlFor
                label.textContent = "Tags";

                const tagbox = document.createElement("div");
                tagbox.id = "tag-box";

                const tag = document.createElement("div");
                tag.id = "tags";

                const input = document.createElement("input");
                input.id = "tag-input";
                input.type = "text";
                input.Placeholder = "Type a tag…";
                input.autocomplete = "off";

                const suggestion = document.createElement("suggestion");
                suggestion.id = "suggestions";
                suggestion.hidden = true;
                tagbox.appendChild(tag);
                tagbox.appendChild(input);

                document.body.appendChild(label);
                document.body.appendChild(tag);
                document.body.appendChild(suggestion);*/


                const zone = document.querySelector("#bigzone");
                const fileinput = document.querySelector("#image");
                const fileList = document.querySelector("#filelist");
                const uploaddetails = document.querySelector("#uploaddetails")

                zone.addEventListener("click", () => fileinput.click());

                zone.addEventListener("keydown", (event) => {
                    if (event.key === "Enter" || event.key === " ") {
                        event.preventDefault();
                        fileinput.click();
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

                    const file = event.dataTransfer.files[0];
                    if (file) showFiles([file]); // Pass a one-file list if showFiles expects a list
                });

                fileinput.addEventListener("change", () => showFiles(fileinput.files));

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


                /*div.appendChild(details);
                fileList.append(div);

                const Title = document.createElement("h2");
                const Description = document.createElement("h2");
                const Tags = document.createElement("h2");
                Title.type = "text";
                Title.Placeholder = "Enter a title";
                Description.Placeholder = "Enter a Description";

                function addtag(Tags) {
                    const tag = document.createElement(input);
                    Tags.appendChild(tag);
                }*/





                const availableTags = ["HTML", "CSS", "JavaScript", "Accessibility", "Design", "PHP", "Python", "Java", "C++", "Ruby", "Swift", "Kotlin", "SQL", "NoSQL", "React", "Angular", "Vue", "Node.js", "Express.js", "Django", "Flask", "Spring Boot", "Laravel", "Symfony", "WordPress", "Drupal", "Joomla", "Magento", "Shopify", "WooCommerce", "Firebase", "AWS", "Azure", "Google Cloud", "Docker", "Kubernetes", "GraphQL", "REST API", "WebSockets", "OAuth", "JWT", "SASS", "LESS", "Bootstrap", "Tailwind CSS", "Material-UI", "Ant Design", "Bulma", "Foundation", "Semantic UI", "jQuery", "TypeScript", "Webpack", "Babel", "ESLint", "Prettier", "Jest", "Mocha", "Chai", "Cypress", "Puppeteer", "Selenium"];
                const selectedTags = new Set();

                const taginput = document.querySelector("#tag-input");
                const tags = document.querySelector("#tags");
                const suggestions = document.querySelector("#suggestions");

                function addTag(tag) {
                    tag = tag.trim();
                    if (!tag || selectedTags.has(tag)) return;

                    selectedTags.add(tag);

                    const chip = document.createElement("span");
                    chip.className = "chip";
                    chip.textContent = tag + " ";

                    const remove = document.createElement("button");
                    remove.type = "button";
                    remove.textContent = "×";
                    remove.setAttribute("aria-label", `Remove ${tag}`);
                    remove.onclick = () => {
                        selectedTags.delete(tag);
                        chip.remove();
                    };

                    chip.append(remove);
                    tags.append(chip);
                    taginput.value = "";
                    suggestions.hidden = true;
                }

                taginput.addEventListener("input", () => {
                    const query = taginput.value.trim().toLowerCase();
                    suggestions.replaceChildren();

                    const matches = availableTags.filter(tag =>
                        tag.toLowerCase().includes(query) && !selectedTags.has(tag)
                    );

                    for (const tag of matches) {
                        const item = document.createElement("li");
                        const button = document.createElement("button");
                        button.type = "button";
                        button.textContent = tag;
                        button.onclick = () => addTag(tag);
                        item.append(button);
                        suggestions.append(item);
                    }

                    suggestions.hidden = !query || matches.length === 0;
                });

                taginput.addEventListener("keydown", event => {
                    if (event.key === "Enter" && taginput.value.trim()) {
                        event.preventDefault();
                        addTag(taginput.value);
                    }
                });
                x


                /*    </div>
    </form>
        <label for="tag-input">Tags</label>
<div id="tag-box">
    <div id="tags"></div>
    <input id="tag-input" type="text" placeholder="Type a tag…" autocomplete="off">
</div>
<ul id="suggestions" hidden></ul>*/
            </script>

            <style>
                #tag-box {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px;
                    border: 1px solid rgba(100, 100, 100, 0.5);
                    padding: 8px 0px 8px 0px;
                    background: transparent;
                }

                #tag-input {
                    border: 0;
                    outline: 0;
                    flex: 1;
                    min-width: 140px;
                }

                .chip {
                    background: #eee;
                    padding: 4px 8px;
                    border: 1px solid rgba(100, 100, 100, 0.5);
                    margin: 2px;
                }

                .chip button {
                    border: 0;
                    background: none;
                    cursor: pointer;
                }

                #suggestions {
                    list-style: none;
                    padding: 0;
                    margin: 4px 0;
                }

                #suggestions button {
                    display: block;
                    width: 100%;
                    text-align: left;
                    padding: 6px;
                }
            </style>
</body>

</html>