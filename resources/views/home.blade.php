<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Task Manager</title>

        <link
            href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700"
            rel="preload"
            as="style"
            onload="this.onload=null;this.rel='stylesheet';"
        />

        <style>
            html,body {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            body {
                font-family: 'Nunito', sans-serif;
                background: url("{{ asset('img/bg1.webp') }}");
                background-size: cover;
                background-attachment: fixed;
            }

            #app {
                width: 100%;
                max-width: 320px;
                min-height: 300px;
                margin: auto;
                background: rgba(0, 32, 43, 0.9);
            }

            @media (min-width: 800px) {
                #app {
                    max-width: 500px;
                }
            }

            .app-title {
                font-size: 22px;
                color: #FFFFFF;
                text-align: center;
                padding: 10px;
                border-bottom: 1px solid #1f3942;
            }

            .folder-breadcrumbs {
                position: relative;
                padding-left: 24px;
                border-bottom: 1px solid #1f3942;
                padding-bottom: 7px;
                padding-top: 5px;
                background: white;
            }

            .folder-breadcrumbs svg {
                position: absolute;
                left: 7px;
                top: 10px;

                cursor: pointer;
            }

            .folder-breadcrumbs .breadcrumb-separator {
                margin-left: 6px;
                margin-right: 6px;
                color: #000000;
                font-size: 12px;
            }

            .folder-breadcrumbs .folder {
                font-size: 12px;
                color: #012a3c;

                cursor: pointer;
            }

            .folder-breadcrumbs .folder.current {
                cursor: auto;
            }

            .loading-status {
                color: #FFFFFF;
                text-align: center;
                font-size: 14px;
                margin-top: 10px;
            }

            .list .list-item {
                padding: 14px 0 14px 0;
                border-bottom: 1px dashed rgba(70, 107, 119, 0.44);
                position: relative;
                min-height: 82px;
            }

            .list .list-item .save-status {
                color: white;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 9999999;
            }

            .list .list-item .save-status.info {
                background: rgba(0, 158, 255, 0.93);
                color: #ffffff;
            }


            .list .list-item .save-status.success {
                background: rgba(39, 255, 0, 0.93);
                color: #032f40;
            }

            .list .list-item .save-status.error {
                background: rgba(255, 0, 0, 0.93);
                color: #ffffff;
            }

            .list .list-item .save-status .save-status-text {
                position: absolute;
                top: 40%;
                width: 100%;
                text-align: center;
                padding: 14px 0;
            }

            .list .list-item .save-status .save-status-text .ok-btn {
                background: white;
                color: black;
                padding: 10px 0;
                max-width: 100px;
                margin: 10px auto;
                cursor: pointer;
            }

            .list .list-item .time-interaction {
                height: 20px;
                width: 30px;
                position: absolute;
                left: 5px;
                text-align: center;
            }

            .list .list-item .time-interaction .play {
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 10px 0 10px 17.3px;
                border-color: transparent transparent transparent #ffffff;
                display: inline-block;
                cursor: pointer;
            }

            .list .list-item .time-interaction .pause {
                width: 100%;
                height: 100%;
                text-align: center;
                display: inline-block;
                cursor: pointer;
            }

            .list .list-item .time-interaction .pause .pause-col {
                height: 100%;
                width: 4px;
                background: #FFFFFF;
                display: inline-block;
            }

            .list .list-item .time-interaction .pause .pause-col:first-child {
                margin-right: 5px;
            }

            .list .list-item .list-item-title {
                color: #FFFFFF;
                font-size: 14px;
                padding-left: 40px;
                padding-right: 30px;

                position: relative;

                cursor: pointer;
            }

            .list .list-item .list-item-title textarea {
                width: 100%;
                background: rgba(0, 0, 0, 0.08);
                border: 1px solid #0b4356;
                color: #ffffff;
                -webkit-appearance: none;
                -moz-appearance: none;
                -ms-appearance: none;
                -o-appearance: none;
                appearance: none;
                outline: none;
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
            }

            .list .list-item .list-item-title svg {
                position: absolute;
                left: 15px;
                top: 2px;
            }

            .list .list-item .list-item-options {
                position: absolute;
                right: 0;
                height: 30px;
                width: 30px;
                cursor: pointer;

                z-index: 999999;
            }


            .list .list-item .list-item-options .option-dot {
                height: 8px;
                width: 8px;
                background: #FFFFFF;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                border-radius: 8px;
                margin: auto;
                margin-bottom: 2px;
            }

            .list .list-item .list-item-options-menu {
                position: absolute;
                background: white;
                border: 3px solid rgb(181 181 180);
                z-index: 999999;
                min-width: 165px;
            }

            .list .list-item .list-item-options-menu .menu-item {
                color: #022c3f;
                font-size: 12px;
                padding: 10px;
                border-bottom: 1px solid #022b40;
                cursor: pointer;
            }

            .list .list-item .list-item-options-menu .menu-item:last-child {
                border-bottom: 0;
            }

            .list .list-item .list-item-options-menu .menu-item:hover {
                color: #FFFFFF;
                background-color: #022c3f;
            }

            .list .list-item .list-item-options-menu .menu-item.green {
                color: #008000;
            }

            .list .list-item .list-item-options-menu .menu-item.green:hover {
                color: #30ff30;
            }

            .list .list-item .list-item-options-menu .menu-item.old-moss-green {
                color: #8f8f40;
            }

            .list .list-item .list-item-options-menu .menu-item.old-moss-green:hover {
                color: #868600;
            }

            .list .list-item .list-item-options-menu .menu-item.gray {
                color: #808080;
            }

            .list .list-item .list-item-options-menu .menu-item.gray:hover {
                color: #aea8a8;
            }

            .list .list-item .list-item-options-menu .menu-item.red {
                color: #ff0000;
            }

            .list .list-item .time-spent {
                color: rgba(255, 198, 2, 0.76);
                text-align: left;
                font-size: 12px;
                margin-top: 10px;

                padding-left: 40px;
                padding-right: 30px;
            }

            .list .list-item .folder {
                color: #7a9fa4;
                text-align: left;
                font-size: 12px;
                margin-top: 10px;
                padding-left: 40px;
                padding-right: 30px;
            }

            .list .list-item .folder span {
                cursor: pointer;
            }

            .list .list-item .folder span.current {
                cursor: auto;
            }

            .list .list-item .folder .breadcrumb-separator {
                margin-left: 6px;
                margin-right: 6px;
                color: #FFFFFF;
                font-size: 12px;
            }

            .list .list-item .tags {
                text-align: right;
                margin-top: 10px;

                padding-left: 40px;
                padding-right: 30px;
            }

            .list .list-item .tags span {
                background: #FFFFFF;
                margin-right: 10px;
                font-size: 10px;
                padding: 4px 10px;

                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                border-radius: 8px;

                cursor: pointer;

                display: inline-block;
                margin-top: 8px;
            }

        </style>

        <script>

            window.Translation = {
                opening_folder: "{{ __('Opening folder.. please wait') }}",

                edit: "{{ __('Edit') }}",
                mark_as_completed: "{{ __('Mark as Completed') }}",
                mark_as_on_hold: "{{ __('Mark as On Hold') }}",
                mark_as_deprecated: "{{ __('Mark as Deprecated') }}",
                delete: "{{ __('Delete') }}",
                saving_changes: "{{ __('Saving changes..') }}",
                saving_changes_failed: "{{ __('Failed to save changes') }}",

                ok: "{{ __('Ok') }}",
            };

            window.App = {
                Helpers: {
                    getVerticalCenter: function (elementHeight, containerHeight) {
                        return (containerHeight/2)-(elementHeight/2);
                    },
                    hideOnClickOutsideElement: function (element, exceptions, optionalCallback) {
                        const outsideClickListener = event => {
                            if (
                                !element.contains(event.target) && this.isElementVisible(element)
                                &&
                                !exceptions.includes(event.target)
                            ) {
                                element.style.display = 'none';
                                removeClickListener();

                                if (typeof optionalCallback === 'function') {
                                    optionalCallback();
                                }
                            }
                        }

                        const removeClickListener = () => {
                            document.removeEventListener('click', outsideClickListener);
                        }

                        document.addEventListener('click', outsideClickListener);
                    },
                    isElementVisible: function (elem) {
                        return !!elem && !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length );
                    },
                    createTextarea: function (id, value) {
                        const textareaEl = document.createElement('textarea');
                        textareaEl.setAttribute(
                            'id',
                            id
                        );
                        textareaEl.value = value;

                        return textareaEl;
                    },
                    makeTextareaHeightAutoResize: function (textareaEl , optionalOnResizeCallback) {
                        textareaEl.style.height = textareaEl.scrollHeight + 'px';

                        textareaEl.onkeyup = function () {
                            textareaEl.style.height = 0;
                            textareaEl.style.height = textareaEl.scrollHeight + 'px';

                            if (typeof optionalOnResizeCallback === 'function') {
                                optionalOnResizeCallback();
                            }
                        };
                    },
                },
                Components: {
                    LoadingStatus: {
                        el: function () {
                            return document.getElementById('loading-status');
                        },
                        show: function(message) {
                            const el = this.el();
                            el.innerText = message;
                            el.style.display = 'block';
                        },
                        hide: function () {
                            const el = this.el();
                            el.style.display = 'none';
                            el.innerHTML = '';
                        }
                    },
                    FolderBreadcrumbs: {
                        parentFolders: [],
                        el: function () {
                            return document.getElementById('folder-breadcrumbs');
                        },
                        show: function (parentFolders) {
                            const el = this.el();
                            const rootFolderEl = this.createRootFolderEl();

                            el.innerHTML = '';
                            el.appendChild(rootFolderEl);

                            if (
                                typeof parentFolders !== 'undefined'
                            ) {
                                this.setParentFolders(parentFolders);
                            }

                            const currentParentFolders = this.getParentFolders();
                            for(var i = 0; i < currentParentFolders.length; i++) {
                                const currentFolder = currentParentFolders[i];
                                const folder = this.createFolderEl(currentFolder);
                                el.appendChild(folder);

                                if (i+1 < currentParentFolders.length) {
                                    const breadcrumbSeparator = this.createBreadcrumbSeparatorEl();
                                    el.appendChild(breadcrumbSeparator);

                                    folder.onclick = function (e) {
                                        window.App.Views.FolderContent.switchToFolder(currentFolder.id);
                                    };
                                } else {
                                    folder.classList.add('current');
                                }
                            }

                            el.style.display = 'block';
                        },
                        createRootFolderEl: function () {
                            const rootFolderEl = document.createElement('div');
                            rootFolderEl.style.display = 'inline-block';

                            rootFolderEl.innerHTML = '';
                            rootFolderEl.innerHTML += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16"> <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/> </svg>';

                            const breadcrumbSeparator = this.createBreadcrumbSeparatorEl();
                            rootFolderEl.appendChild(breadcrumbSeparator);

                            rootFolderEl.onclick = function () {
                                window.App.Views.FolderContent.switchToFolder(null);
                            };

                            return rootFolderEl;
                        },
                        createFolderEl: function (folder) {
                            const folderEl = document.createElement('span');
                            folderEl.classList.add('folder');
                            folderEl.innerText = folder.name;

                            return folderEl;
                        },
                        createBreadcrumbSeparatorEl: function () {
                            const breadcrumbSeparator = document.createElement('span');
                            breadcrumbSeparator.classList.add('breadcrumb-separator');
                            breadcrumbSeparator.innerText = '/';

                            return breadcrumbSeparator;
                        },
                        setParentFolders: function (parentFolders) {
                            this.parentFolders = parentFolders;
                        },
                        getParentFolders: function () {
                            return this.parentFolders;
                        }
                    },
                    FolderContentList: {
                        el: function () {
                            return document.getElementById('folder-content-list');
                        },
                        show: function () {
                            this.el().style.display = 'block';
                        },
                        addListItem: function (listItemObj) {
                            const newListItem = this.Components.ListItem.createEl(listItemObj);
                            this.el().appendChild(newListItem.listItemEl);

                            this.Components.ListItem
                            .Components.TimeInteraction.centerTimeInteractionEl(listItemObj);

                            this.Components.ListItem
                            .Components.ItemOptions.centerMainComponents(listItemObj);
                        },
                        clearListItems: function () {
                            this.el().innerHTML = '';
                        },
                        Components: {
                            ListItem: {
                                getElId: function (listItemObj) {
                                    return  listItemObj.list_item_type + '-' + listItemObj.id;
                                },
                                getEl: function (listItemObj) {
                                    return document.getElementById(this.getElId(listItemObj));
                                },
                                createEl: function (listItemObj) {
                                    const listItem = document.createElement('div');
                                    listItem.classList.add('list-item');
                                    listItem.setAttribute(
                                        'id',
                                        this.getElId(listItemObj)
                                    );

                                    const saveStatus = this.Components.SaveStatus.createEl(listItemObj);
                                    const timeInteraction = this.Components.TimeInteraction.createEl(listItemObj);
                                    const listItemOptions = this.Components.ItemOptions.Components.ToggleButton.createEl(listItemObj);
                                    const listItemOptionsMenu = this.Components.ItemOptions.Components.Menu.createEl(listItemObj);
                                    const listItemTitle = this.Components.ItemTitle.createEl(listItemObj);
                                    const timeSpent = this.Components.TimeSpent.createEl(listItemObj);
                                    //const parentFolders = this.Components.ParentFolders.createEl(listItemObj);
                                    const tags = this.Components.Tags.createEl(listItemObj);

                                    listItem.appendChild(saveStatus);
                                    listItem.appendChild(timeInteraction);
                                    listItem.appendChild(listItemOptions);
                                    listItem.appendChild(listItemOptionsMenu);
                                    listItem.appendChild(listItemTitle);
                                    listItem.appendChild(timeSpent);
                                    //TODO: only show parent folders in Item when viewing 'All tasks in folder and subfolders'
                                    //listItem.appendChild(parentFolders);
                                    listItem.appendChild(tags);

                                    return {
                                        listItemEl: listItem,
                                        timeInteractionEl: timeInteraction,
                                        listItemTitleEl: listItemTitle,
                                        listItemOptionsEl: listItemOptions,
                                        listItemOptionsMenuEl: listItemOptionsMenu,
                                    };
                                },
                                Components: {
                                    SaveStatus: {
                                        getContainerElId: function (listItemObj) {
                                            return 'list-item-save-status-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getContainerEl: function (listItemObj) {
                                            return document.getElementById(this.getContainerElId(listItemObj));
                                        },
                                        getElId: function (listItemObj) {
                                            return 'list-item-save-status-text-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getEl: function (listItemObj) {
                                            return document.getElementById(this.getElId(listItemObj));
                                        },
                                        createEl: function (listItemObj) {
                                            const saveStatusEl = document.createElement('div');
                                            saveStatusEl.classList.add('save-status');
                                            saveStatusEl.setAttribute('id', this.getContainerElId(listItemObj));

                                            const saveStatusTextEl = document.createElement('div');
                                            saveStatusTextEl.classList.add('save-status-text');
                                            saveStatusTextEl.setAttribute('id', this.getElId(listItemObj));

                                            saveStatusEl.appendChild(saveStatusTextEl);

                                            saveStatusEl.style.display = 'none';

                                            return saveStatusEl;
                                        },
                                        resetColorClasses: function (listItemObj, except = []) {
                                            const containerEl = this.getContainerEl(listItemObj);
                                            const colorClasses = ['error', 'info', 'success'];

                                            for(var i = 0; i < colorClasses.length; i++) {
                                                const colorClass = colorClasses[i];

                                                if (except.indexOf(colorClass) === -1) {
                                                    containerEl.classList.remove(colorClass);
                                                }
                                            }
                                        },
                                        showInfoMessage: function (message, listItemObj) {
                                            this.showMessage(message, 'info', listItemObj);
                                        },
                                        showErrorMessage: function (message, listItemObj, okBtnCallback) {
                                            this.showMessage(message, 'error', listItemObj, true, okBtnCallback);
                                        },
                                        showSuccessMessage: function (message, listItemObj) {
                                            this.showMessage(message, 'success', listItemObj);
                                        },
                                        showMessage: function (message, colorClass, listItemObj, showOkBtn = false, okBtnCallback = null) {
                                            const containerEl = this.getContainerEl(listItemObj);
                                            const textEl = this.getEl(listItemObj);

                                            textEl.innerHTML = '';
                                            textEl.innerText = message;

                                            if (showOkBtn === true) {
                                                const okBtn = document.createElement('div');
                                                okBtn.classList.add('ok-btn');
                                                okBtn.innerText = window.Translation.ok;

                                                const $this = this;
                                                okBtn.onclick = function (e) {
                                                    $this.hide(listItemObj);

                                                    if (
                                                        typeof okBtnCallback === 'function'
                                                    ) {
                                                        okBtnCallback();
                                                    }
                                                };

                                                textEl.appendChild(okBtn);
                                            }

                                            containerEl.classList.add(colorClass);
                                            this.resetColorClasses(listItemObj, [colorClass]);
                                            containerEl.style.display = 'block';

                                            const center = window.App.Helpers.getVerticalCenter(
                                                textEl.offsetHeight,
                                                containerEl.offsetHeight
                                            );

                                            textEl.style.top = center + 'px';

                                            window.location.href = '#' + this.getElId(listItemObj);
                                        },
                                        hide: function (listItemObj) {
                                            const containerEl = this.getContainerEl(listItemObj);
                                            const textEl = this.getEl(listItemObj);

                                            textEl.innerText = '';
                                            containerEl.style.display = 'none';

                                            window.location.href = '#' + window.App.Components.FolderContentList
                                            .Components.ListItem.getElId(listItemObj);
                                        }
                                    },
                                    TimeInteraction: {
                                        getElId: function (listItemObj) {
                                            return 'time-interaction-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getEl: function (listItemObj) {
                                            return document.getElementById(this.getElId(listItemObj));
                                        },
                                        createEl: function (listItemObj) {
                                            const timeInteraction = document.createElement('div');
                                            timeInteraction.classList.add('time-interaction');
                                            timeInteraction.setAttribute(
                                                'id',
                                                this.getElId(listItemObj)
                                            );

                                            if (listItemObj.list_item_type === 'task') {
                                                const playButton = this.createPlayButtonEl(listItemObj);
                                                const pauseButton = this.createPauseButtonEl(listItemObj);

                                                timeInteraction.appendChild(playButton);
                                                timeInteraction.appendChild(pauseButton);
                                            } else {
                                                timeInteraction.style.display = 'none';
                                            }

                                            return timeInteraction;
                                        },
                                        createPlayButtonEl: function (listItemObj) {
                                            const playButton = document.createElement('div');
                                            playButton.classList.add('play');
                                            //playButton.style.display = 'none';
                                            return playButton;
                                        },
                                        createPauseButtonEl: function (listItemObj) {
                                            const pauseButton = document.createElement('div');
                                            pauseButton.classList.add('pause');
                                            pauseButton.style.display = 'none';

                                            const pauseCol1 = document.createElement('div');
                                            pauseCol1.classList.add('pause-col');

                                            const pauseCol2 = document.createElement('div');
                                            pauseCol2.classList.add('pause-col');

                                            pauseButton.appendChild(pauseCol1);
                                            pauseButton.appendChild(pauseCol2);

                                            return pauseButton;
                                        },
                                        centerTimeInteractionEl: function (listItemObj) {
                                            const listItemEl = window.App.Components.FolderContentList
                                            .Components.ListItem.getEl(listItemObj);

                                            const timeInteractionButtonEl = this.getEl(listItemObj);
                                            // center time interaction vertically
                                            if ( timeInteractionButtonEl.style.display !== 'none' ) {
                                                const timeInteractionYPos = window.App.Helpers.getVerticalCenter(
                                                    timeInteractionButtonEl.offsetHeight,
                                                    listItemEl.offsetHeight
                                                );
                                                timeInteractionButtonEl.style.top = timeInteractionYPos + 'px';
                                            }
                                        },
                                    },
                                    ItemOptions: {
                                        Components: {
                                            ToggleButton: {
                                                getElId: function (listItemObj) {
                                                    return 'list-item-options-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                                },
                                                getEl: function (listItemObj) {
                                                    return document.getElementById(this.getElId(listItemObj));
                                                },
                                                createEl: function (listItemObj) {
                                                    const listItemOptions = document.createElement('div');
                                                    listItemOptions.classList.add('list-item-options');
                                                    listItemOptions.setAttribute(
                                                        'id',
                                                        this.getElId(listItemObj)
                                                    );

                                                    const optionDot1 = document.createElement('div');
                                                    optionDot1.classList.add('option-dot');

                                                    const optionDot2 = document.createElement('div');
                                                    optionDot2.classList.add('option-dot');

                                                    const optionDot3 = document.createElement('div');
                                                    optionDot3.classList.add('option-dot');

                                                    listItemOptions.appendChild(optionDot1);
                                                    listItemOptions.appendChild(optionDot2);
                                                    listItemOptions.appendChild(optionDot3);

                                                    listItemOptions.onclick = function (e) {
                                                        const menuEl = document.getElementById(
                                                            'list-item-options-menu-' + listItemObj.id + '-' + listItemObj.list_item_type
                                                        );

                                                        if (menuEl.style.display === 'block') {
                                                            menuEl.style.display = 'none';
                                                        } else {
                                                            menuEl.style.display = 'block';
                                                            window.App.Helpers.hideOnClickOutsideElement(
                                                                menuEl,
                                                                [
                                                                    listItemOptions,
                                                                    optionDot1,
                                                                    optionDot2,
                                                                    optionDot3
                                                                ]
                                                            );
                                                        }
                                                    };

                                                    return listItemOptions;
                                                },
                                            },
                                            Menu: {
                                                getElId: function (listItemObj) {
                                                    return 'list-item-options-menu-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                                },
                                                getEl: function (listItemObj) {
                                                    return document.getElementById(this.getElId(listItemObj));
                                                },
                                                createEl: function (listItemObj) {
                                                    const listItemOptionsMenuEl = document.createElement('div');
                                                    listItemOptionsMenuEl.classList.add('list-item-options-menu');
                                                    listItemOptionsMenuEl.style.display = 'none';

                                                    listItemOptionsMenuEl.setAttribute(
                                                        'id',
                                                        this.getElId(listItemObj)
                                                    );

                                                    switch (listItemObj.list_item_type) {
                                                        case 'task':
                                                            this.addTaskMenuItemsToMenuEl(listItemOptionsMenuEl, listItemObj);
                                                            break;
                                                        case 'folder':
                                                            this.addFolderMenuItemsToMenuEl(listItemOptionsMenuEl, listItemObj);
                                                            break;
                                                    }

                                                    return listItemOptionsMenuEl;
                                                },
                                                addTaskMenuItemsToMenuEl: function (listItemOptionsMenuEl, listItemObj) {
                                                    const editMenuItemEl = this.createEditTaskMenuItemEl(listItemOptionsMenuEl, listItemObj);

                                                    const markCompletedMenuItemEl = this.createMenuItemEl(
                                                        window.Translation.mark_as_completed,
                                                        'green'
                                                    );

                                                    const markOnHoldMenuItemEl = this.createMenuItemEl(
                                                        window.Translation.mark_as_on_hold,
                                                        'old-moss-green'
                                                    );

                                                    const markDeprecatedMenuItemEl = this.createMenuItemEl(
                                                        window.Translation.mark_as_deprecated,
                                                        'gray'
                                                    );

                                                    const deleteMenuItemEl =  this.createMenuItemEl(
                                                        window.Translation.delete,
                                                        'red'
                                                    );

                                                    listItemOptionsMenuEl.innerHTML = '';
                                                    listItemOptionsMenuEl.appendChild(editMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(markCompletedMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(markOnHoldMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(markDeprecatedMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(deleteMenuItemEl);
                                                },
                                                addFolderMenuItemsToMenuEl: function (listItemOptionsMenuEl, listItemObj) {
                                                    const editMenuItemEl = this.createMenuItemEl(window.Translation.edit);

                                                    const deleteMenuItemEl =  this.createMenuItemEl(
                                                        window.Translation.delete,
                                                        'red'
                                                    );

                                                    listItemOptionsMenuEl.innerHTML = '';
                                                    listItemOptionsMenuEl.appendChild(editMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(deleteMenuItemEl);
                                                },
                                                createMenuItemEl: function (innerText, colorClass) {
                                                    const menuItemEl = document.createElement('div');
                                                    menuItemEl.classList.add('menu-item');

                                                    if (typeof colorClass !== 'undefined') {
                                                        menuItemEl.classList.add(colorClass);
                                                    }

                                                    menuItemEl.innerText = innerText;
                                                    return menuItemEl;
                                                },
                                                createEditTaskMenuItemEl: function (listItemOptionsMenuEl, listItemObj) {
                                                    const editMenuItemEl = this.createMenuItemEl(window.Translation.edit);
                                                    editMenuItemEl.onclick = function (e) {
                                                        window.App.Components.FolderContentList.Components.ListItem.Components.ItemTitle.enableEditMode(listItemObj);
                                                        listItemOptionsMenuEl.style.display = 'none';
                                                    };
                                                    return editMenuItemEl;
                                                },
                                            }
                                        },
                                        centerMainComponents: function (listItemObj) {
                                            const listItemEl = window.App.Components.FolderContentList
                                            .Components.ListItem.getEl(listItemObj);

                                            const toggleButtonEl = this.Components.ToggleButton.getEl(listItemObj);
                                            const menuEl = this.Components.Menu.getEl(listItemObj);

                                            // center list item options 3 dots btn vertically
                                            const listItemOptionsBtnYPos = window.App.Helpers.getVerticalCenter(
                                                toggleButtonEl.offsetHeight,
                                                listItemEl.offsetHeight
                                            );
                                            toggleButtonEl.style.top = listItemOptionsBtnYPos + 'px';

                                            // set list item options menu position
                                            menuEl.style.top = toggleButtonEl.style.top;
                                            menuEl.style.right = toggleButtonEl.offsetWidth + 'px';
                                        },
                                    },
                                    ItemTitle: {
                                        api: "{{ url('/api/tasks/edit-title') }}",
                                        getContainerElId: function (listItemObj) {
                                            return 'list-item-title-container-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getContainerEl: function (listItemObj) {
                                            return document.getElementById(
                                                this.getContainerElId(listItemObj)
                                            );
                                        },
                                        getElId: function (listItemObj) {
                                            return 'list-item-title-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getEl: function (listItemObj) {
                                            return document.getElementById(
                                                this.getElId(listItemObj)
                                            );
                                        },
                                        getTextareaElId: function (listItemObj) {
                                            return 'list-item-title-input-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getTextareaEl: function (listItemObj) {
                                            return document.getElementById(this.getTextareaElId(listItemObj));
                                        },
                                        getIcon: function (listItemObj) {
                                            switch (listItemObj.list_item_type) {
                                                case 'task':
                                                    return '<svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" fill="white"></path> </svg>';
                                                case 'folder':
                                                    return '<svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16"> <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z" fill="white"></path> </svg>';
                                            }
                                            return '';
                                        },
                                        createContainerEl: function (listItemObj) {
                                            const listItemTitleContainer = document.createElement('div');
                                            listItemTitleContainer.classList.add('list-item-title');
                                            listItemTitleContainer.setAttribute(
                                                'id',
                                                this.getContainerElId(listItemObj)
                                            );
                                            listItemTitleContainer.innerHTML = '';
                                            const icon = this.getIcon(listItemObj);
                                            listItemTitleContainer.innerHTML += icon;

                                            return listItemTitleContainer;
                                        },
                                        createTitleEl: function (listItemObj) {
                                            const listItemTitleTextEl = document.createElement('span');
                                            listItemTitleTextEl.setAttribute(
                                                'id',
                                                this.getElId(listItemObj)
                                            );


                                            switch (listItemObj.list_item_type) {
                                                case 'task':
                                                    listItemTitleTextEl.innerText = listItemObj.title;
                                                    break;
                                                case 'folder':
                                                    listItemTitleTextEl.innerText = listItemObj.name;
                                                    listItemTitleTextEl.onclick = function (e) {
                                                        window.App.Views.FolderContent.switchToFolder(listItemObj.id);
                                                    };
                                                    break;
                                            }
                                            return listItemTitleTextEl;
                                        },
                                        createEl: function (listItemObj) {
                                            const listItemTitleContainer = this.createContainerEl(listItemObj);
                                            const listItemTitleTextEl = this.createTitleEl(listItemObj);
                                            listItemTitleContainer.appendChild(listItemTitleTextEl);
                                            return listItemTitleContainer;
                                        },
                                        enableEditMode: function (listItemObj) {
                                            const listItemTitleContainer = this.getContainerEl(listItemObj);
                                            listItemTitleContainer.innerHTML = '';

                                            const icon = this.getIcon(listItemObj);
                                            listItemTitleContainer.innerHTML += icon;

                                            const listItemTitleInputEl = window.App.Helpers.createTextarea(
                                                this.getTextareaElId(listItemObj),
                                                listItemObj.title
                                            );
                                            //TODO: Max length of list-item should be equal to allowed in db
                                           listItemTitleInputEl.setAttribute('maxlength', 2048);

                                            listItemTitleContainer.appendChild(listItemTitleInputEl);

                                            window.App.Helpers.makeTextareaHeightAutoResize(
                                                listItemTitleInputEl,
                                                function () {
                                                    window.App.Components.FolderContentList
                                                    .Components.ListItem
                                                    .Components.TimeInteraction.centerTimeInteractionEl(listItemObj);

                                                    window.App.Components.FolderContentList
                                                    .Components.ListItem
                                                    .Components.ItemOptions.centerMainComponents(listItemObj);
                                                }
                                            );

                                            listItemTitleInputEl.focus();

                                            const $this = this;
                                            listItemTitleInputEl.addEventListener('focusout', (event) => {
                                                $this.saveTitle(
                                                    event.target.value,
                                                    listItemObj,
                                                    function (listItemObjParam) {
                                                        $this.disableEditMode(listItemObjParam);
                                                    }
                                                );
                                            });
                                        },
                                        disableEditMode: function (listItemObj) {
                                            const listItemTitleContainer = this.getContainerEl(listItemObj);
                                            listItemTitleContainer.innerHTML = '';

                                            const icon = this.getIcon(listItemObj);
                                            listItemTitleContainer.innerHTML += icon;

                                            const listItemTitleTextEl = this.createTitleEl(listItemObj);
                                            listItemTitleContainer.appendChild(listItemTitleTextEl);

                                            window.App.Components.FolderContentList
                                                    .Components.ListItem
                                                    .Components.TimeInteraction.centerTimeInteractionEl(listItemObj);

                                                    window.App.Components.FolderContentList
                                                    .Components.ListItem
                                                    .Components.ItemOptions.centerMainComponents(listItemObj);
                                        },
                                        saveTitle: function (newTitle, listItemObj, onSaveCallback) {

                                            var xhr = new XMLHttpRequest();
                                            xhr.withCredentials = true;

                                            window.App.Components.FolderContentList
                                            .Components.ListItem
                                            .Components.SaveStatus.showInfoMessage(
                                                window.Translation.saving_changes,
                                                listItemObj
                                            );

                                            const $this = this;
                                            xhr.addEventListener("readystatechange", function() {
                                                if(
                                                    this.readyState === 4
                                                ) {

                                                    if ( this.status === 200 ) {
                                                        listItemObj.title = newTitle;
                                                        if (
                                                            typeof onSaveCallback === 'function'
                                                        ) {
                                                            onSaveCallback(listItemObj);
                                                        }

                                                        window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                        .Components.SaveStatus.hide(listItemObj);
                                                        return;
                                                    }

                                                    try {
                                                        const jsonRes = JSON.parse(this.responseText);

                                                        if (
                                                            typeof jsonRes.message !== 'undefined'
                                                        ) {
                                                            window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.SaveStatus.showErrorMessage(
                                                                jsonRes.message,
                                                                listItemObj,
                                                                function () {
                                                                    $this.getTextareaEl(listItemObj).focus();
                                                                }
                                                            );
                                                            return;
                                                        }
                                                    } catch (error) {}

                                                    window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                        .Components.SaveStatus.showErrorMessage(
                                                            window.Translation.saving_changes_failed,
                                                            listItemObj,
                                                            function () {
                                                                $this.getTextareaEl(listItemObj).focus();
                                                            }
                                                        );
                                                }
                                            });

                                            xhr.open("POST", this.api, true);
                                            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                                            xhr.send(JSON.stringify(
                                                {
                                                    task_id: listItemObj.id,
                                                    title: newTitle
                                                }
                                            ));

                                        }
                                    },
                                    TimeSpent: {
                                        createEl: function (listItemObj) {
                                            const timeSpent = document.createElement('div');
                                            timeSpent.classList.add('time-spent');

                                            if (
                                                typeof listItemObj.time_spent_today !== 'undefined'
                                            ) {
                                                timeSpent.innerHTML = 'time spent on this task today: <b>' + listItemObj.time_spent_today + '</b>';
                                            } else {
                                                timeSpent.style.display = 'none';
                                            }

                                            return timeSpent;
                                        },
                                    },
                                    ParentFolders: {
                                        createEl: function (listItemObj) {
                                            const parentFolders = document.createElement('div');
                                            parentFolders.classList.add('folder');

                                            for(var i = 0; i < listItemObj.parent_folders.length; i++) {
                                                const parentFolder = listItemObj.parent_folders[i];
                                                const parentFolderName = parentFolder.name;

                                                const parentFolderEl = document.createElement('span');
                                                parentFolderEl.innerText = parentFolderName;

                                                parentFolders.appendChild(parentFolderEl);

                                                if (
                                                    (i+1) < listItemObj.parent_folders.length
                                                ) {
                                                    parentFolderEl.onclick = function (e) {
                                                        window.App.Views.FolderContent.switchToFolder(parentFolder.id);
                                                    };

                                                    const breadcrumbSeparator = this.createBreadcrumbSeparatorEl();
                                                    parentFolders.appendChild(breadcrumbSeparator);
                                                } else {
                                                    parentFolderEl.classList.add('current');
                                                }
                                            }

                                            return parentFolders;
                                        },
                                        createBreadcrumbSeparatorEl: function () {
                                            const breadcrumbSeparator = document.createElement('span');
                                            breadcrumbSeparator.classList.add('breadcrumb-separator');
                                            breadcrumbSeparator.innerText = '/';
                                            return breadcrumbSeparator;
                                        },
                                    },
                                    Tags: {
                                        createEl: function (listItemObj) {
                                            const tags = document.createElement('div');
                                            tags.classList.add('tags');

                                            for(var i = 0; i < listItemObj.tags.length; i++) {
                                                const tag = listItemObj.tags[i];
                                                const tagName = tag.name;
                                                const tagEl = document.createElement('span');
                                                tagEl.innerText = tagName;

                                                tags.appendChild(tagEl);
                                            }

                                            return tags;
                                        }
                                    }
                                }
                            }
                        },
                    },
                },
                Views: {
                    FolderContent: {
                        api: "{{ url('/api/folder-content/list') }}",
                        currentFolderId: null,
                        show: function () {
                            this.fetchFolderContent();
                        },
                        setCurrentFolderId: function (folderId) {
                            this.currentFolderId = folderId;
                        },
                        getCurrentFolderId: function () {
                            return this.currentFolderId;
                        },
                        switchToFolder: function (folderId) {
                            this.setCurrentFolderId(folderId);
                            this.fetchFolderContent();
                        },
                        fetchFolderContent: function () {
                            var xhr = new XMLHttpRequest();
                            xhr.withCredentials = true;

                            window.App.Components.FolderContentList.clearListItems();
                            window.App.Components.LoadingStatus.show(
                                window.Translation.opening_folder
                            );
                            xhr.addEventListener("readystatechange", function() {
                                if(this.readyState === 4) {
                                    window.App.Components.LoadingStatus.hide();
                                    try {
                                        const folderContentJson = JSON.parse(this.responseText);
                                        window.App.Components.FolderBreadcrumbs.show(folderContentJson.parent_folders);
                                        window.App.Components.FolderContentList.show();

                                        // add tasks first
                                        for(var i = 0; i < folderContentJson.tasks.length; i++) {
                                            const listItem = folderContentJson.tasks[i];
                                            listItem.list_item_type = 'task';
                                            window.App.Components.FolderContentList.addListItem(
                                                listItem
                                            );
                                        }

                                        // add folders last
                                        for(var i = 0; i < folderContentJson.folders.length; i++) {
                                            const listItem = folderContentJson.folders[i];
                                            listItem.list_item_type = 'folder';
                                            window.App.Components.FolderContentList.addListItem(
                                                listItem
                                            );
                                        }

                                    } catch (error) {
                                        // notify could not fetch/list folder content ( unexpected invalid json response )
                                    }
                                }
                            });

                            var urlStr = this.api;
                            const currentFolderId = this.getCurrentFolderId();
                            if (currentFolderId != null) {
                                urlStr += '?folder=' + currentFolderId;
                            }

                            xhr.open("POST", urlStr);

                            xhr.send();
                        }
                    }
                }
            };
        </script>
    </head>
    <body>
        <div id="app">
            <div class="app-title">Task Manager</div>
            <div class="folder-breadcrumbs" id="folder-breadcrumbs" style="display: none"></div>
            <div class="loading-status" id="loading-status" style="display: none"></div>
            <div class="list" id="folder-content-list" style="display: none"></div>
        </div>


        @if(isset($view))
            <script>
                window.App.currentView = '{{ $view }}';
            </script>
        @endif


        <script>
            if (
                typeof window.App.currentView !== 'undefined'
                &&
                typeof window.App.Views[window.App.currentView] !== 'undefined'
                &&
                typeof window.App.Views[window.App.currentView].show === 'function'
            ) {
                window.App.Views[window.App.currentView].show();
            }
        </script>

        <script>

            /**
             * Rotating background functionality
             */

            const backgroundList = [
                "{{ asset('img/bg1.webp') }}",
                "{{ asset('img/bg2.webp') }}",
            ];

            function setRandomBgImage() {
                const randBg = Math.floor(Math.random() * backgroundList.length);
                document.body.style.backgroundImage = "url('" + backgroundList[randBg] +"')";
            }

            setRandomBgImage();

            setInterval(function() {
                setRandomBgImage();
            }, 60*1000);

            /**
             * -----------------------------------
             */
        </script>
    </body>
</html>
