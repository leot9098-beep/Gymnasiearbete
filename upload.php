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
                <label for="image" style="border: rgb(100, 100, 100) 1px solid; padding: 80px; width: 100%;"><input type="file" id="image" name="image" accept="image/jpeg , image/png, image/gif, image/webp" hidden>
                    <img src="assets/Upload.png"> </img> <br>
                    <span style="font-size: 20px; font-weight:bold">Upload a image here</span>
                    <br> <span>Supports jpg, png, gif and webp files up to 100MB</span>

                </label>

            </div>
            <ul id="filelist"></ul>

            <div id="uploaddetails" hidden>
                <div id="tag-box">
                    <input type="text" id="title" name="title" placeholder="Add a title..." autocomplete="off">
                </div>

                <div id="tag-box">
                    <textarea id="desciption" name="description" placeholder="Add a description..." autocomplete="off"></textarea>
                </div>



                <div id="tag-box">
                    <div id="tags"></div>
                    <input id="tag-input" type="text" placeholder="Add tags..." autocomplete="off">
                    </input>

                </div>
                <ul id="suggestions"></ul>
                <input type="submit" class="flexbutton" name="submit" value="Upload">
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
                    uploaddetails.hidden = false;
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
                    remove.textContent = "X";
                    remove.style.fontWeight = "bold";
                    remove.style.color = "white";
                    remove.onmouseenter = () => {
                        remove.style.color = "darkgray"
                    }
                    remove.onmouseleave = () => {
                        remove.style.color = "white"
                    }

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

                    for (let i = 0; i < Math.min(matches.length, 10); i++) {
                        const item = document.createElement("li");
                        const button = document.createElement("button");
                        button.type = "button";
                        button.textContent = matches[i];
                        button.onclick = () => addTag(matches[i]);
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
                    border: 1px solid rgba(100, 100, 100, 0.5);
                    padding: 8px 0px 8px 0px;
                    background: rgba(75, 75, 75, 0.5);
                    margin-bottom: 10px;
                }

                #tag-input,
                #desciption,
                #title {
                    display: flex;
                    flex-wrap: wrap;
                    border: 0;
                    outline: 0;
                    flex: 1;
                    min-width: 140px;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    font-size: small;
                }

                textarea {
                    field-sizing: content;
                    resize: none;
                    min-height: calc(1em +16px);
                    max-height: calc(5em +16px);
                    background: none;
                    color: white;
                }

                .chip {
                    background: rgba(45, 45, 45, 0.5);
                    padding: 4px 8px;
                    border: 1px solid rgba(100, 100, 100, 0.5);
                    margin: 2px;
                    color: white;
                    display: inline-flex;
                }

                .chip button {
                    border: 0;
                    background: none;
                    cursor: pointer;
                }

                #suggestions {
                    position: absolute;
                    list-style: none;
                    padding: 0;
                    margin: 4px 0;

                }

                #suggestions :hover {
                    background-color: rgb(100, 100, 100);
                }

                #suggestions button {
                    display: block;
                    min-width: 600px;

                    text-align: left;
                    padding: 6px;
                    color: white;
                    background: rgba(45, 45, 45);
                    border: 1px solid rgba(100, 100, 100, 0.5);

                }

                #uploaddetails {
                    text-align: left;
                }

                #uploaddetails input {
                    background: none;
                    color: white;

                    width: 100%;
                }
            </style>
</body>

</html>