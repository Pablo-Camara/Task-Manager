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

            .app-header {
                position: relative;
            }

            .clock-icon {
                display: inline-block;
                position: absolute;
                top: 10px;
                left: 10px;
                cursor: pointer;
            }

            .clock-icon svg {
                height: 30px;
                width: auto;
            }

            .app-title {
                font-size: 22px;
                color: #FFFFFF;
                text-align: center;
                padding: 10px;
                border-bottom: 1px solid #1f3942;
            }

            #login-form {
                padding-bottom: 14px;
            }

            #login-form h1 {
                color: #FFFFFF;
                text-align: center;
                margin-top: 10px;
                margin-bottom: 0;
            }

            #login-form p {
                color: white;
                text-align: center;
                margin-top: 4px;
            }

            #login-form .form {
                max-width: 300px;
                margin: auto;
            }

            #login-form .form .label {
                color: white;
                display: inline-block;
                margin-right: 10px;
                width: 100px;
                text-align: right;
            }

            #login-form .form input[type="text"],
            #login-form .form input[type="password"] {
                -webkit-appearance:     none;
                -moz-appearance:        none;
                -ms-appearance:         none;
                -o-appearance:          none;
                appearance:             none;
                border: none;
                outline: none;
            }

            #login-form .form .error-feedback {
                text-align: center;
                color: red;
                margin-top: 8px;
            }

            #login-form .form .buttons {
                text-align: center;
                margin-top: 10px;
            }

            #login-form .form .buttons .link-container {
                margin-top: 20px;
            }

            #login-form .form .buttons .link-container a {
                color: white;
            }

            .btn {
                cursor: pointer;
            }

            .btn.btn-simple-white {
                display: inline-block;
                padding: 5px 15px;
                background: white;
                color: #002a3c;
            }

            .running-tasks {
                border-left: 2px solid white;
                border-right: 2px solid white;
            }

            .running-tasks .header {
                background: #ffffff;
                padding: 10px;
                position: relative;
            }

            .running-tasks .header svg {
                height: 30px;
                width: auto;
                position: absolute;
                left: 10px;
                top: 6px;
            }

            .running-tasks .header span {
                margin-left: 40px;
                color: #002a3c;
                font-size: 16px;
            }

            .running-tasks .header .close-btn {
                position: absolute;
                right: 10px;
                top: 10px;
                color: red;
                font-size: 16px;
                cursor: pointer;
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
                color: #073140;
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

            .loading-status {
                color: #FFFFFF;
                text-align: center;
                font-size: 14px;
                margin-top: 10px;
                padding-bottom: 10px;
            }

            .list .list-item {
                padding: 14px 0 14px 0;
                border-bottom: 1px dashed rgba(70, 107, 119, 0.44);
                position: relative;
                min-height: 82px;
            }

            .list .list-item.choose-folder-overlay-visible {
                min-height: 300px;
                overflow: hidden;
            }

            .select-current-folder-link {
                display: block;
                text-align: center;
                text-decoration: underline;
                cursor: pointer;
                padding-top: 10px;
                margin-top: 10px;
                padding-bottom: 10px;
                margin-bottom: 10px;
                border-bottom: 1px dashed rgb(255 225 12 / 30%);
                border-top: 1px dashed rgb(255 225 12 / 30%);
            }

            .list .list-item .choose-folder-overlay,
            .list .list-item .info-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
            }

            .list .list-item .choose-folder-overlay {
                z-index: 99999999;
                background: rgb(0 32 43 / 94%);
                color: #ffffff;
            }

            .list .list-item .choose-folder-overlay .close-btn {
                color: red;
                font-size: 22px;
                position: absolute;
                top: 0px;
                right: 10px;
                cursor: pointer;
            }

            .list .list-item .choose-folder-overlay .folders-list {
                padding: 0 10px;
                max-height: 250px;
                overflow: auto;
            }

            .list .list-item .choose-folder-overlay .folders-list .folders-list-item {
                position: relative;
                border-bottom: 1px dashed rgba(70, 107, 119, 0.44);
                padding-bottom: 6px;
                padding-top: 6px;
            }

            .list .list-item .choose-folder-overlay .folders-list .folders-list-item .folder-name {
                position: relative;
            }

            .list .list-item .choose-folder-overlay .folders-list .folders-list-item .folder-name svg {
                color: white;
                position: absolute;
                top: 3px;
            }

            .list .list-item .choose-folder-overlay .folders-list .folders-list-item .folder-name span {
                color: #FFFFFF;
                font-size: 14px;
                position: relative;
                cursor: pointer;
                margin-left: 24px;
            }

            .list .list-item .choose-folder-overlay .folders-list .folders-list-item .select-folder-container {
                text-align: right;
            }

            .list .list-item .choose-folder-overlay .folders-list .folders-list-item .select-folder-link {
                font-size: 12px;
                text-decoration: underline;
                cursor: pointer;
                display: inline-block;
            }

            .list .list-item .info-overlay {
                color: white;
                z-index: 999999999;
            }

            .list .list-item .choose-folder-overlay .title {
                text-align: center;
                padding: 14px 0;
            }

            .list .list-item .info-overlay.info {
                background: rgba(0, 158, 255, 0.93);
                color: #ffffff;
            }


            .list .list-item .info-overlay.success {
                background: rgba(39, 255, 0, 0.93);
                color: #032f40;
            }

            .list .list-item .info-overlay.error {
                background: rgba(255, 0, 0, 0.93);
                color: #ffffff;
            }

            .list .list-item .info-overlay .info-overlay-text {
                position: absolute;
                top: 40%;
                width: 100%;
                text-align: center;
                padding: 14px 0;
            }

            .list .list-item .info-overlay .info-overlay-text .ok-btn {
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

                z-index: 9999999;
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
                word-break: break-all;
            }

            .list .list-item.folder .list-item-title span {
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

            .app-header .folder-options-toggle,
            .list .list-item .list-item-options {
                position: absolute;
                right: 0;
                height: 30px;
                width: 30px;
                cursor: pointer;

                z-index: 999999;
            }


            .app-header .folder-options-toggle .option-dot,
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

            .app-header .folder-options-menu,
            .list .list-item .list-item-options-menu {
                position: absolute;
                background: white;
                border: 3px solid rgb(181 181 180);
                z-index: 999999;
                min-width: 165px;
            }

            .app-header .folder-options-menu .menu-item.has-icon span
             {
                margin-left: 24px;
             }

            .app-header .folder-options-menu .menu-item,
            .list .list-item .list-item-options-menu .menu-item {
                color: #022c3f;
                font-size: 12px;
                padding: 10px;
                border-bottom: 1px solid #022b40;
                cursor: pointer;
            }

            .app-header .folder-options-menu .menu-item svg {
                position: absolute;
            }

            .app-header .folder-options-menu .menu-item {
                color: #022c3f;
                background-color: #FFFFFF;
                border-bottom: 1px solid #022c3f;
            }

            .app-header .folder-options-menu .menu-item:last-child,
            .list .list-item .list-item-options-menu .menu-item:last-child {
                border-bottom: 0;
            }


            .app-header .folder-options-menu .menu-item:hover {
                color: #FFFFFF;
                background-color: #022c3f;
            }


            .list .list-item .list-item-options-menu .menu-item:hover {
                color: #FFFFFF;
                background-color: #022c3f;
            }

            .app-header .folder-options-menu .menu-item.green,
            .list .list-item .list-item-options-menu .menu-item.green {
                color: #008000;
            }

            .app-header .folder-options-menu .menu-item.green:hover,
            .list .list-item .list-item-options-menu .menu-item.green:hover {
                color: #30ff30;
            }

            .app-header .folder-options-menu .menu-item.old-moss-green,
            .list .list-item .list-item-options-menu .menu-item.old-moss-green {
                color: #8f8f40;
            }

            .app-header .folder-options-menu .menu-item.old-moss-green:hover,
            .list .list-item .list-item-options-menu .menu-item.old-moss-green:hover {
                color: #868600;
            }

            .app-header .folder-options-menu .menu-item.gray,
            .list .list-item .list-item-options-menu .menu-item.gray {
                color: #808080;
            }

            .app-header .folder-options-menu .menu-item.gray:hover,
            .list .list-item .list-item-options-menu .menu-item.gray:hover {
                color: #aea8a8;
            }

            .app-header .folder-options-menu .menu-item.red,
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

            .list .list-item > .folder {
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
                folder_is_empty: "{{ __('This folder is empty') }}",

                task: {
                    save: "{{ __('Save task name') }}",
                    edit: "{{ __('Edit task name') }}",
                    move: "{{ __('Move to different folder') }}",
                    cancel: "{{ __('Cancel editing task name') }}",
                    delete: "{{ __('Delete task') }}",
                    starting_timer: "{{ __('Starting the timer..') }}",
                    stopping_timer: "{{ __('Stopping the timer..') }}",
                },
                folder: {
                    save: "{{ __('Save folder name') }}",
                    edit: "{{ __('Edit folder name') }}",
                    move: "{{ __('Move to different folder') }}",
                    cancel: "{{ __('Cancel editing folder name') }}",
                    delete: "{{ __('Delete folder') }}",
                },
                mark_as_completed: "{{ __('Mark as Completed') }}",
                mark_as_on_hold: "{{ __('Mark as On Hold') }}",
                mark_as_deprecated: "{{ __('Mark as Deprecated') }}",
                saving_changes: "{{ __('Saving changes..') }}",
                saving_changes_failed: "{{ __('Failed to save changes') }}",
                ok: "{{ __('Ok') }}",
            };

            window.App = {
                Auth: {
                    isLoggedIn: false,
                    submitLoginForm: function () {
                        const username = document.getElementById('login-username');
                        const password = document.getElementById('login-password');

                        if (
                            false == (
                                username.value.trim().length == 0
                                ||
                                password.value.trim().length == 0
                            )
                        ) {
                            document.authForm.submit();
                        }
                    }
                },
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
                    scrollTo: function(element, to, duration) {
                        if (duration <= 0) return;
                        var difference = to - element.scrollTop;
                        var perTick = difference / duration * 10;

                        setTimeout(function() {
                            element.scrollTop = element.scrollTop + perTick;
                            if (element.scrollTop === to) return;
                            window.App.Helpers.scrollTo(element, to, duration - 10);
                        }, 10);
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
                    AppHeader: {
                        el: function () {
                            return document.getElementById('app-header');
                        },
                        show: function () {
                            const el = this.el();
                            el.innerHTML = '';

                            const appTitle = this.Components.AppTitle.createEl();

                            const folderOptionsToggleButton = this.Components.FolderOptionsMenu
                                                                .Components.ToggleButton.createEl();

                            const folderOptionsMenu = this.Components.FolderOptionsMenu
                                                        .Components.Menu.createEl();

                            const runningTasksButton = this.Components.RunningTasksButton.createEl();


                            el.appendChild(appTitle);

                            if (window.App.Auth.isLoggedIn) {
                                el.appendChild(folderOptionsToggleButton);
                                el.appendChild(folderOptionsMenu);
                                el.appendChild(runningTasksButton);
                                this.Components.FolderOptionsMenu.centerMainComponents();
                            }
                        },
                        Components: {
                            AppTitle: {
                                createEl: function () {
                                    const appTitleEl = document.createElement('div');
                                    appTitleEl.classList.add('app-title');
                                    appTitleEl.innerText = 'Task Manager';
                                    return appTitleEl;
                                }
                            },
                            FolderOptionsMenu: {
                                Components: {
                                    ToggleButton: {
                                        getElId: function () {
                                            return 'folder-options-toggle';
                                        },
                                        el: function () {
                                            return document.getElementById(this.getElId());
                                        },
                                        createEl: function () {
                                            const folderOptionsToggleEl = document.createElement('div');
                                            folderOptionsToggleEl.classList.add('folder-options-toggle');
                                            folderOptionsToggleEl.setAttribute(
                                                'id',
                                                this.getElId()
                                            );

                                            const optionDot1 = document.createElement('div');
                                            optionDot1.classList.add('option-dot');

                                            const optionDot2 = document.createElement('div');
                                            optionDot2.classList.add('option-dot');

                                            const optionDot3 = document.createElement('div');
                                            optionDot3.classList.add('option-dot');

                                            folderOptionsToggleEl.appendChild(optionDot1);
                                            folderOptionsToggleEl.appendChild(optionDot2);
                                            folderOptionsToggleEl.appendChild(optionDot3);

                                            folderOptionsToggleEl.onclick = function (e) {
                                                const menuEl = window.App.Components.AppHeader
                                                                .Components.FolderOptionsMenu
                                                                    .Components.Menu.toggleShow(
                                                                        [
                                                                            folderOptionsToggleEl,
                                                                            optionDot1,
                                                                            optionDot2,
                                                                            optionDot3
                                                                        ]
                                                                    );
                                            };

                                            return folderOptionsToggleEl;
                                        },
                                    },
                                    Menu: {
                                        getElId: function () {
                                            return 'folder-options-menu';
                                        },
                                        el: function () {
                                            return document.getElementById(this.getElId());
                                        },
                                        createEl: function () {
                                            const folderOptionsMenuEl = document.createElement('div');
                                            folderOptionsMenuEl.classList.add('folder-options-menu');
                                            folderOptionsMenuEl.style.display = 'none';

                                            folderOptionsMenuEl.setAttribute(
                                                'id',
                                                this.getElId()
                                            );

                                            this.renderRootMenu(folderOptionsMenuEl);

                                            return folderOptionsMenuEl;
                                        },
                                        hide: function () {
                                            this.el().style.display = 'none';
                                        },
                                        toggleShow: function (hideOnClickOutsideElementExceptions = []) {
                                            const menuEl = this.el();
                                            if (menuEl.style.display === 'block') {
                                                menuEl.style.display = 'none';
                                            } else {
                                                menuEl.style.display = 'block';
                                                window.App.Helpers.hideOnClickOutsideElement(
                                                    menuEl,
                                                    hideOnClickOutsideElementExceptions
                                                );
                                            }
                                        },
                                        renderRootMenu: function (folderOptionsMenuEl) {
                                            if (
                                                typeof folderOptionsMenuEl === 'undefined'
                                            ) {
                                                folderOptionsMenuEl = this.el();
                                            }

                                            folderOptionsMenuEl.innerHTML = '';

                                            const hoverIconForCreateNewTaskMenuEl = '<svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" fill="white"></path> </svg>';
                                            const iconForCreateNewTaskMenuItemEl = '<svg style="color: rgb(2, 44, 63);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" fill="#022c3f"></path> </svg>';

                                            const createNewTaskMenuItemEl = this.createMenuItemEl(
                                                'Create new task',
                                                null,
                                                iconForCreateNewTaskMenuItemEl,
                                                hoverIconForCreateNewTaskMenuEl
                                            );

                                            createNewTaskMenuItemEl.onclick = function (e) {
                                                window.App.Components.FolderContentList.addNewListItem('task');
                                                folderOptionsMenuEl.style.display = 'none';
                                            };


                                            const hoverIconForCreateNewFolderMenuItemEl = '<svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16"> <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z" fill="white"></path> </svg>';
                                            const iconForCreateNewFolderMenuItemEl = '<svg style="color: rgb(2, 44, 63);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16"> <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z" fill="#022c3f"></path> </svg>';

                                            const createNewFolderMenuItemEl = this.createMenuItemEl(
                                                'Create new folder',
                                                null,
                                                iconForCreateNewFolderMenuItemEl,
                                                hoverIconForCreateNewFolderMenuItemEl
                                            );

                                            createNewFolderMenuItemEl.onclick = function (e) {
                                                window.App.Components.FolderContentList.addNewListItem('folder');
                                                folderOptionsMenuEl.style.display = 'none';
                                            };

                                            folderOptionsMenuEl.appendChild(createNewTaskMenuItemEl);
                                            folderOptionsMenuEl.appendChild(createNewFolderMenuItemEl);

                                        },
                                        createMenuItemEl: function (innerText, colorClass, activeSvgIcon, hoverSvgIcon) {
                                            const menuItemEl = document.createElement('div');
                                            menuItemEl.classList.add('menu-item');

                                            if (
                                                typeof colorClass === 'string'
                                            ) {
                                                menuItemEl.classList.add(colorClass);
                                            }

                                            const menuItemTextEl = document.createElement('span');
                                            menuItemTextEl.innerText = innerText;

                                            if (
                                                typeof activeSvgIcon !== 'undefined'
                                            ) {
                                                menuItemEl.classList.add('has-icon');
                                                menuItemEl.innerHTML = '';
                                                menuItemEl.innerHTML += activeSvgIcon;

                                                if (
                                                    typeof hoverSvgIcon !== 'undefined'
                                                ) {
                                                    menuItemEl.onmouseenter = function (e) {
                                                        menuItemEl.innerHTML = '';
                                                        menuItemEl.innerHTML += hoverSvgIcon;
                                                        menuItemEl.appendChild(menuItemTextEl);
                                                    };

                                                    menuItemEl.onmouseleave = function (e) {
                                                        menuItemEl.innerHTML = '';
                                                        menuItemEl.innerHTML += activeSvgIcon;
                                                        menuItemEl.appendChild(menuItemTextEl);
                                                    };
                                                }
                                            }



                                            menuItemEl.appendChild(menuItemTextEl);
                                            return menuItemEl;
                                        },
                                    }
                                },
                                centerMainComponents: function () {
                                    const appHeaderEl = window.App.Components.AppHeader.el();

                                    const toggleButtonEl = this.Components.ToggleButton.el();
                                    const menuEl = this.Components.Menu.el();

                                    // center list item options 3 dots btn vertically
                                    const folderOptionsToggleBtnYPos = window.App.Helpers.getVerticalCenter(
                                        toggleButtonEl.offsetHeight,
                                        appHeaderEl.offsetHeight
                                    );
                                    toggleButtonEl.style.top = folderOptionsToggleBtnYPos + 'px';

                                    // set list item options menu position
                                    menuEl.style.top = toggleButtonEl.style.top;
                                    menuEl.style.right = toggleButtonEl.offsetWidth + 'px';
                                },
                            },
                            RunningTasksButton: {
                                getElId: function () {
                                    return 'show-running-tasks';
                                },
                                el: function () {
                                    return document.getElementById(this.getElId());
                                },
                                hide: function () {
                                    this.el().style.display = 'none';
                                },
                                show: function () {
                                    this.el().style.display = 'inline-block';
                                },
                                createEl: function () {
                                    const containerEl = document.createElement('div');
                                    containerEl.classList.add('clock-icon');
                                    containerEl.setAttribute(
                                        'id',
                                        this.getElId()
                                    );

                                    const svgIconEl = '<svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16"> <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z" fill="white"></path> <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z" fill="white"></path> </svg>';

                                    containerEl.innerHTML = svgIconEl;

                                    const $this = this;
                                    containerEl.onclick = function(e) {
                                        $this.hide();
                                        window.App.Components.RunningTasks.show();
                                    };

                                    return containerEl;
                                }
                            }
                        },
                    },
                    RunningTasks: {
                        visible: false,
                        el: function () {
                            return document.getElementById('running-tasks');
                        },
                        show: function () {
                            const $this = this;
                            this.Components.CloseButton.initialize(
                                function(e) {
                                    $this.hide();
                                    window.App.Components.FolderContentList.clearListItems(
                                        $this.Components.TaskList.getElId()
                                    );
                                    window.App.Components.AppHeader.Components.RunningTasksButton.show();
                                }
                            );
                            this.el().style.display = 'block';
                            this.visible = true;
                            this.Components.TaskList.fetch();
                        },
                        hide: function () {
                            this.el().style.display = 'none';
                            this.visible = false;
                        },
                        refresh: function () {
                            this.Components.TaskList.fetch();
                        },
                        isVisible: function () {
                            return this.visible ? true : false;
                        },
                        Components: {
                            CloseButton: {
                                hasInitialized: false,
                                el: function () {
                                    return document.getElementById('close-running-tasks');
                                },
                                initialize: function (onclickFunc) {
                                    if (this.hasInitialized === false) {
                                        this.el().onclick = onclickFunc;
                                        this.hasInitialized = true;
                                    }
                                }
                            },
                            TaskList: {
                                api: "{{ url('/api/tasks/running') }}",
                                getElId: function () {
                                    return 'running-tasks-list';
                                },
                                getLoadingElId: function () {
                                    return 'loading-status-rtl';
                                },
                                el: function () {
                                    return document.getElementById(this.getElId());
                                },
                                fetch: function () {
                                    var xhr = new XMLHttpRequest();
                                    xhr.withCredentials = true;

                                    window.App.Components.FolderContentList.clearListItems(this.getElId());
                                    window.App.Components.LoadingStatus.show(
                                        'Loading..', //TODO: translate
                                        this.getLoadingElId()
                                    );

                                    const $this = this;
                                    xhr.addEventListener("readystatechange", function() {
                                        if(this.readyState === 4) {

                                            window.App.Components.LoadingStatus.hide(
                                                $this.getLoadingElId()
                                            );

                                            try {
                                                const tasksJson = JSON.parse(this.responseText);

                                                // add tasks
                                                for(var i = 0; i < tasksJson.length; i++) {
                                                    const listItem = tasksJson[i];
                                                    listItem.list_item_type = 'task';
                                                    window.App.Components.FolderContentList.addListItem(
                                                        listItem,
                                                        null,
                                                        $this.getElId(),
                                                        true
                                                    );
                                                }

                                                if (tasksJson.length == 0) {
                                                    window.App.Components.LoadingStatus.show(
                                                        'You are currently not working on any tasks', //TODO: translate
                                                        $this.getLoadingElId()
                                                    );
                                                }

                                            } catch (error) {
                                                // TODO: notify could not fetch/list folder content ( unexpected invalid json response )
                                            }
                                        }
                                    });

                                    xhr.open("POST", this.api);
                                    xhr.send();
                                }
                            }
                        }
                    },
                    LoadingStatus: {
                        mainElId: function () {
                            return 'loading-status';
                        },
                        getEl: function (elId) {
                            return document.getElementById(elId);
                        },
                        createEl: function (elId) {
                            const loadingStatusEl = document.createElement('div');
                            loadingStatusEl.classList.add('loading-status');
                            loadingStatusEl.setAttribute(
                                'id',
                                elId
                            );
                            loadingStatusEl.style.display = 'none';
                            return loadingStatusEl;
                        },
                        show: function(message, elId = null) {
                            const el = this.getEl(elId != null ? elId : this.mainElId());
                            el.innerText = message;
                            el.style.display = 'block';
                        },
                        hide: function (elId = null) {
                            const el = this.getEl(elId != null ? elId : this.mainElId());
                            el.style.display = 'none';
                            el.innerHTML = '';
                        },
                    },
                    FolderBreadcrumbs: {
                        getMainElId: function () {
                            return 'folder-breadcrumbs';
                        },
                        getEl: function (elId) {
                            return document.getElementById(elId);
                        },
                        createEl: function (elId, parentFolders, switchToFolderFunc) {
                            const folderBreadcrumbsContainer = document.createElement('div');
                            folderBreadcrumbsContainer.classList.add('folder-breadcrumbs');
                            folderBreadcrumbsContainer.setAttribute('id', elId);

                            this.createElInnerEls(
                                folderBreadcrumbsContainer,
                                parentFolders,
                                switchToFolderFunc
                            );

                            return folderBreadcrumbsContainer;
                        },
                        createElInnerEls: function (el, parentFolders, switchToFolderFunc) {
                            const rootFolderEl = this.createRootFolderEl(switchToFolderFunc);

                            el.innerHTML = '';
                            el.appendChild(rootFolderEl);


                            for(var i = 0; i < parentFolders.length; i++) {
                                const currentFolder = parentFolders[i];
                                const folder = this.createFolderEl(currentFolder, switchToFolderFunc);
                                el.appendChild(folder);

                                if (i+1 < parentFolders.length) {
                                    const breadcrumbSeparator = this.createBreadcrumbSeparatorEl();
                                    el.appendChild(breadcrumbSeparator);
                                } else {
                                    folder.classList.add('current');
                                }
                            }
                        },
                        showMainEl: function (parentFolders) {
                            this.show(
                                this.getMainElId(),
                                parentFolders,
                                function (folderId) {
                                    window.App.Views.FolderContent.switchToFolder(folderId);
                                }
                            );
                        },
                        show: function (elId, parentFolders, switchToFolderFunc) {
                            const el = this.getEl(elId);
                            this.createElInnerEls(
                                el,
                                parentFolders,
                                switchToFolderFunc
                            );
                            el.style.display = 'block';
                        },
                        createRootFolderEl: function (switchToFolderFunc) {
                            const rootFolderEl = document.createElement('div');
                            rootFolderEl.style.display = 'inline-block';

                            rootFolderEl.innerHTML = '';
                            rootFolderEl.innerHTML += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16"> <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/> </svg>';

                            const breadcrumbSeparator = this.createBreadcrumbSeparatorEl();
                            rootFolderEl.appendChild(breadcrumbSeparator);

                            rootFolderEl.onclick = function () {
                                if (
                                    typeof switchToFolderFunc === 'function'
                                ) {
                                    switchToFolderFunc(null);
                                }
                            };

                            return rootFolderEl;
                        },
                        createFolderEl: function (folder, switchToFolderFunc) {
                            const folderEl = document.createElement('span');
                            folderEl.classList.add('folder');
                            folderEl.innerText = folder.name;

                            folderEl.onclick = function (e) {
                                if (
                                    typeof switchToFolderFunc === 'function'
                                ) {
                                    switchToFolderFunc(folder.id);
                                }
                            };

                            return folderEl;
                        },
                        createBreadcrumbSeparatorEl: function () {
                            const breadcrumbSeparator = document.createElement('span');
                            breadcrumbSeparator.classList.add('breadcrumb-separator');
                            breadcrumbSeparator.innerText = '/';

                            return breadcrumbSeparator;
                        }
                    },
                    FolderContentList: {
                        apis: {
                            task: {
                                create_new: "{{ url('/api/tasks/create-new') }}"
                            },
                            folder: {
                                create_new: "{{ url('/api/folders/create-new') }}"
                            },
                        },
                        el: function (listId) {
                            if (listId == null) {
                                listId = 'folder-content-list';
                            }
                            return document.getElementById(listId);
                        },
                        show: function () {
                            this.el().style.display = 'block';
                        },
                        getLastIndexForListItemType: function (listItemType) {
                            const el = this.el();
                            const listItems = el.querySelectorAll('.list-item');

                            var lastIndex = -1;
                            for(var i = 0; i < listItems.length; i++) {
                                const listItem = listItems[i];
                                if (listItem.classList.contains(listItemType)) {
                                    lastIndex = i;
                                }
                            }

                            return lastIndex;
                        },
                        addListItem: function (listItemObj, orderPositionNumber = null, listId = null, showParentFolders = false) {
                            const newListItem = this.Components.ListItem.createEl(listItemObj, showParentFolders);
                            const el = this.el(listId);

                            if (orderPositionNumber === null) {
                                el.appendChild(newListItem.listItemEl);
                            } else {
                                el.insertBefore(newListItem.listItemEl, el.children[orderPositionNumber]);
                            }

                            this.Components.ListItem
                            .Components.TimeInteraction.centerTimeInteractionEl(listItemObj);

                            this.Components.ListItem
                            .Components.ItemOptions.centerMainComponents(listItemObj);

                            return newListItem.listItemEl;
                        },
                        addNewListItem: function (listItemType) {
                            // in case we have "This folder is empty" visible..
                            window.App.Components.LoadingStatus.hide();

                            var xhr = new XMLHttpRequest();
                            xhr.withCredentials = true;

                            const $this = this;
                            xhr.addEventListener("readystatechange", function() {
                                if(this.readyState === 4) {
                                    const listItemObj = JSON.parse(this.responseText);
                                    listItemObj.list_item_type = listItemType;

                                    const tempOrderPosition = $this.getLastIndexForListItemType(listItemType) + 1;
                                    const newListItem = $this.addListItem(listItemObj, tempOrderPosition);

                                    const scrollDuration = 400;
                                    window.App.Helpers.scrollTo(
                                        document.documentElement,
                                        newListItem.offsetTop,
                                        scrollDuration
                                    );
                                    setTimeout(function () {
                                        window.App.Components.FolderContentList
                                            .Components.ListItem.enableEditTitleMode(listItemObj);
                                    }, scrollDuration+100);
                                }
                            });

                            const currentFolderId = window.App.Views.FolderContent.getCurrentFolderId();

                            var urlStr = this.apis[listItemType].create_new;

                            if (currentFolderId != null) {
                                urlStr += '?current-folder=' + currentFolderId;
                            }

                            xhr.open("POST", urlStr);
                            xhr.send();

                        },
                        clearListItems: function (listId = null) {
                            this.el(listId).innerHTML = '';
                        },
                        Components: {
                            ListItem: {
                                getElId: function (listItemObj) {
                                    return listItemObj.list_item_type + '-' + listItemObj.id;
                                },
                                getEl: function (listItemObj) {
                                    return document.getElementById(this.getElId(listItemObj));
                                },
                                remove: function (listItemObj) {
                                    const el = this.getEl(listItemObj);
                                    el.remove();
                                },
                                createEl: function (listItemObj, showParentFolders = false) {
                                    const listItem = document.createElement('div');
                                    listItem.classList.add('list-item');
                                    listItem.classList.add(listItemObj.list_item_type);
                                    listItem.setAttribute(
                                        'id',
                                        this.getElId(listItemObj)
                                    );

                                    const infoOverlay = this.Components.InfoOverlay.createEl(listItemObj);
                                    const timeInteraction = this.Components.TimeInteraction.createEl(listItemObj);
                                    const listItemOptions = this.Components.ItemOptions.Components.ToggleButton.createEl(listItemObj);
                                    const listItemOptionsMenu = this.Components.ItemOptions.Components.Menu.createEl(listItemObj);
                                    const listItemTitle = this.Components.ItemTitle.createEl(listItemObj);
                                    const timeSpent = this.Components.TimeSpent.createEl(listItemObj);

                                    const tags = this.Components.Tags.createEl(listItemObj);

                                    listItem.appendChild(infoOverlay);
                                    listItem.appendChild(timeInteraction);
                                    listItem.appendChild(listItemOptions);
                                    listItem.appendChild(listItemOptionsMenu);
                                    listItem.appendChild(listItemTitle);
                                    listItem.appendChild(timeSpent);
                                    //TODO: only show parent folders in specific views, because we already have breadcrumbs
                                    if (showParentFolders) {
                                        const parentFolders = this.Components.ParentFolders.createEl(listItemObj);
                                        listItem.appendChild(parentFolders);
                                    }

                                    listItem.appendChild(tags);

                                    return {
                                        listItemEl: listItem,
                                        timeInteractionEl: timeInteraction,
                                        listItemTitleEl: listItemTitle,
                                        listItemOptionsEl: listItemOptions,
                                        listItemOptionsMenuEl: listItemOptionsMenu,
                                    };
                                },
                                enableEditTitleMode: function (listItemObj) {
                                    this.Components.ItemTitle.enableEditMode(listItemObj);
                                    const listItemOptionsMenuEl = this.Components.ItemOptions.Components.Menu.getEl(listItemObj);
                                    this.Components.ItemOptions.Components.Menu.renderEditingListItemTitleMenuItems(
                                        listItemOptionsMenuEl,
                                        listItemObj
                                    );
                                },
                                Components: {
                                    InfoOverlay: {
                                        getContainerElId: function (listItemObj) {
                                            return 'list-item-info-overlay-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getContainerEl: function (listItemObj) {
                                            return document.getElementById(this.getContainerElId(listItemObj));
                                        },
                                        getElId: function (listItemObj) {
                                            return 'list-item-info-overlay-text-' + listItemObj.id + '-' + listItemObj.list_item_type;
                                        },
                                        getEl: function (listItemObj) {
                                            return document.getElementById(this.getElId(listItemObj));
                                        },
                                        createEl: function (listItemObj) {
                                            const infoOverlayEl = document.createElement('div');
                                            infoOverlayEl.classList.add('info-overlay');
                                            infoOverlayEl.setAttribute('id', this.getContainerElId(listItemObj));

                                            const infoOverlayTextEl = document.createElement('div');
                                            infoOverlayTextEl.classList.add('info-overlay-text');
                                            infoOverlayTextEl.setAttribute('id', this.getElId(listItemObj));

                                            infoOverlayEl.appendChild(infoOverlayTextEl);

                                            infoOverlayEl.style.display = 'none';

                                            return infoOverlayEl;
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
                                        showSuccessMessage: function (message, listItemObj, okBtnCallback = null) {
                                            this.showMessage(message, 'success', listItemObj, okBtnCallback != null, okBtnCallback);
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
                                        },
                                        hide: function (listItemObj) {
                                            const containerEl = this.getContainerEl(listItemObj);
                                            const textEl = this.getEl(listItemObj);

                                            textEl.innerText = '';
                                            containerEl.style.display = 'none';
                                        }
                                    },
                                    ChooseFolderOverlay: {
                                        apis: {
                                            move: {
                                                task: "{{ url('/api/tasks/move') }}",
                                                folder: "{{ url('/api/folders/move') }}"
                                            }
                                        },
                                        getElId: function (listItemObj) {
                                            return 'li-choose-folder-overlay-' + listItemObj.list_item_type + '-' + listItemObj.id;
                                        },
                                        getEl: function (listItemObj) {
                                            return document.getElementById(this.getElId(listItemObj));
                                        },
                                        createEl: function (listItemObj) {
                                            const chooseFolderOverlayEl = document.createElement('div');
                                            chooseFolderOverlayEl.classList.add('choose-folder-overlay');
                                            chooseFolderOverlayEl.setAttribute(
                                                'id',
                                                this.getElId(listItemObj)
                                            );

                                            const $this = this;

                                            const closeBtn = this.Components.CloseButton.createEl(
                                                listItemObj,
                                                function (e) {
                                                    $this.hide(listItemObj);
                                                }
                                            );
                                            const titleEl = this.Components.Title.createEl();
                                            const folderBreadcrumbsEl = this.Components.FolderBreadcrumbs.createEl(listItemObj);
                                            const loadingStatusEl = this.Components.LoadingStatus.createEl(listItemObj);
                                            const selectCurrentFolderLink = this.Components.SelectCurrentFolderLink.createEl(listItemObj);
                                            const foldersList = this.Components.FoldersList.createEl(listItemObj);

                                            chooseFolderOverlayEl.appendChild(closeBtn);
                                            chooseFolderOverlayEl.appendChild(titleEl);
                                            chooseFolderOverlayEl.appendChild(folderBreadcrumbsEl);
                                            chooseFolderOverlayEl.appendChild(loadingStatusEl);
                                            chooseFolderOverlayEl.appendChild(selectCurrentFolderLink);
                                            chooseFolderOverlayEl.appendChild(foldersList);

                                            return chooseFolderOverlayEl;
                                        },
                                        show: function(listItemObj) {
                                            const listItemEl = window.App.Components.FolderContentList
                                                .Components.ListItem.getEl(listItemObj);
                                            listItemEl.classList.add('choose-folder-overlay-visible');

                                            const existingEl = this.getEl(listItemObj);
                                            if(existingEl) {
                                                existingEl.style.display = 'block';
                                                this.Components.FoldersList.fetchFoldersInFolder(
                                                    window.App.Views.FolderContent.currentFolderId,
                                                    listItemObj
                                                );
                                                return;
                                            }

                                            const chooseFolderOverlayEl = this.createEl(listItemObj);
                                            chooseFolderOverlayEl.style.display = 'block';

                                            const infoOverlayEl = window.App.Components.FolderContentList
                                                .Components.ListItem
                                                    .Components.InfoOverlay.getContainerEl(listItemObj);

                                            infoOverlayEl.parentNode.insertBefore(chooseFolderOverlayEl, infoOverlayEl);
                                            this.Components.FoldersList.fetchFoldersInFolder(
                                                window.App.Views.FolderContent.currentFolderId,
                                                listItemObj
                                            );
                                        },
                                        hide: function (listItemObj) {
                                            const listItemEl = window.App.Components.FolderContentList
                                                .Components.ListItem.getEl(listItemObj);

                                            listItemEl.classList.remove('choose-folder-overlay-visible');

                                            this.getEl(listItemObj).style.display = 'none';
                                        },
                                        moveListItem: function (listItemObj, selectedFolderId) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.withCredentials = true;

                                            window.App.Components.FolderContentList
                                                .Components.ListItem
                                                    .Components.InfoOverlay.showInfoMessage(
                                                        'Moving item..', //TODO: translate
                                                        listItemObj
                                                    );

                                            xhr.addEventListener("readystatechange", function() {
                                                if(this.readyState === 4) {
                                                    if (this.status === 200) {
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                                .Components.ChooseFolderOverlay.hide(listItemObj);

                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.InfoOverlay.showSuccessMessage(
                                                                'Item moved successfully', //TODO: translate
                                                                listItemObj,
                                                                function (e) {
                                                                    window.App.Components.FolderContentList
                                                                        .Components.ListItem.remove(listItemObj);
                                                                }
                                                            );

                                                    }
                                                }
                                            });

                                            const api = this.apis.move[listItemObj.list_item_type];

                                            xhr.open("POST", api + '?id=' + listItemObj.id + '&new-parent-folder=' + selectedFolderId);

                                            xhr.send();
                                        },
                                        Components: {
                                            CloseButton: {
                                                createEl: function (listItemObj, onclickEvent) {
                                                    const closeBtn = document.createElement('div');
                                                    closeBtn.classList.add('close-btn');
                                                    closeBtn.innerText = 'x';
                                                    closeBtn.onclick = onclickEvent;
                                                    return closeBtn;
                                                }
                                            },
                                            Title: {
                                                createEl: function (listItemObj, onclickEvent) {
                                                    const titleEl = document.createElement('div');
                                                    titleEl.classList.add('title');
                                                    //TODO: translate
                                                    titleEl.innerText = 'Choose the destination folder:';
                                                    return titleEl;
                                                }
                                            },
                                            FolderBreadcrumbs: {
                                                getElId: function (listItemObj) {
                                                    return 'cfo-folder-breadcrumbs-' + listItemObj.list_item_type + '-' + listItemObj.id;
                                                },
                                                createEl: function (listItemObj) {
                                                    const folderBreadcrumbsEl = window.App.Components.FolderBreadcrumbs.createEl(
                                                        this.getElId(listItemObj),
                                                        [],
                                                        function (folderId) {
                                                            window.App.Components.FolderContentList
                                                                .Components.ListItem
                                                                    .Components.ChooseFolderOverlay
                                                                        .Components.FoldersList.switchToFolder(folderId, listItemObj);
                                                        }
                                                    );
                                                    return folderBreadcrumbsEl;
                                                }
                                            },
                                            LoadingStatus: {
                                                getElId: function (listItemObj) {
                                                    return 'cfo-loading-status-' + listItemObj.list_item_type + '-' + listItemObj.id;
                                                },
                                                createEl: function (listItemObj) {
                                                    const loadingStatusEl = window.App.Components.LoadingStatus.createEl(
                                                        this.getElId(listItemObj)
                                                    );
                                                    return loadingStatusEl;
                                                },
                                                show: function (message, listItemObj) {
                                                    window.App.Components.LoadingStatus.show(message, this.getElId(listItemObj));
                                                },
                                                hide: function (listItemObj) {
                                                    window.App.Components.LoadingStatus.hide(this.getElId(listItemObj));
                                                },
                                            },
                                            SelectCurrentFolderLink: {
                                                getElId: function (listItemObj) {
                                                    return 'select-curr-folder-link-' + listItemObj.list_item_type + '-' + listItemObj.id;
                                                },
                                                getEl: function (listItemObj) {
                                                    return document.getElementById(this.getElId(listItemObj));
                                                },
                                                createEl: function (listItemObj) {
                                                    const selectCurrentFolderLinkEl = document.createElement('div');
                                                    selectCurrentFolderLinkEl.classList.add('select-current-folder-link');
                                                    selectCurrentFolderLinkEl.style.display = 'none';

                                                    selectCurrentFolderLinkEl.setAttribute(
                                                        'id',
                                                        this.getElId(listItemObj)
                                                    );

                                                    selectCurrentFolderLinkEl.innerText = 'Move to this folder'; //TODO: translate
                                                    selectCurrentFolderLinkEl.onclick = function (e) {
                                                        const selectedFolderId = window.App.Components.FolderContentList
                                                                                    .Components.ListItem
                                                                                        .Components.ChooseFolderOverlay
                                                                                            .Components.FoldersList.getCurrentFolderId(listItemObj);

                                                        window.App.Components.FolderContentList
                                                                    .Components.ListItem
                                                                        .Components.ChooseFolderOverlay.moveListItem(listItemObj, selectedFolderId);
                                                    };

                                                    return selectCurrentFolderLinkEl;
                                                },
                                                show: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'block';
                                                },
                                                hide: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'none';
                                                },
                                            },
                                            FoldersList: {
                                                api: "{{ url('/api/folder-content/list-folders') }}",
                                                getElId: function (listItemObj) {
                                                    return 'cfo-folders-list-' + listItemObj.list_item_type + '-' + listItemObj.id;
                                                },
                                                getEl: function (listItemObj) {
                                                    return document.getElementById(this.getElId(listItemObj));
                                                },
                                                createEl: function (listItemObj) {
                                                    const foldersListEl = document.createElement('div');
                                                    foldersListEl.classList.add('folders-list');
                                                    foldersListEl.style.display = 'none';
                                                    foldersListEl.setAttribute(
                                                        'id',
                                                        this.getElId(listItemObj)
                                                    );

                                                    return foldersListEl;
                                                },
                                                show: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'block';
                                                },
                                                hide: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'none';
                                                },
                                                switchToFolder: function (folderId, listItemObj) {
                                                    this.setCurrentFolderId(folderId, listItemObj);
                                                    this.fetchFoldersInFolder(folderId, listItemObj);
                                                },
                                                setCurrentFolderId: function (folderId, listItemObj) {
                                                    this.getEl(listItemObj).setAttribute('data-current-folder-id', folderId);
                                                },
                                                getCurrentFolderId: function (listItemObj) {
                                                    var currFolderId = this.getEl(listItemObj).getAttribute('data-current-folder-id');
                                                    if (currFolderId === 'null') {
                                                        currFolderId = null;
                                                    }
                                                    return currFolderId;
                                                },
                                                clearListItems: function (listItemObj) {
                                                    this.getEl(listItemObj).innerHTML = '';
                                                },
                                                addListItem: function (parentListItemObj, listItemObjToAdd) {
                                                    const foldersListEl = this.getEl(parentListItemObj);

                                                    const folderEl = document.createElement('div');
                                                    folderEl.classList.add('folders-list-item');

                                                    const folderNameEl = document.createElement('div');
                                                    folderNameEl.classList.add('folder-name');

                                                    const folderSvgEl = '<svg style="" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16"> <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z" fill="white"></path> </svg>';
                                                    const folderNameTextEl = document.createElement('span');
                                                    folderNameTextEl.innerText = listItemObjToAdd.title;

                                                    const $this = this;
                                                    folderNameTextEl.onclick = function(e) {
                                                        $this.switchToFolder(listItemObjToAdd.id, parentListItemObj);
                                                    };

                                                    folderNameEl.innerHTML = '';
                                                    folderNameEl.innerHTML += folderSvgEl;
                                                    folderNameEl.appendChild(folderNameTextEl);

                                                    folderEl.appendChild(folderNameEl);

                                                    const isSameFolder = (
                                                        (parentListItemObj.list_item_type === 'task' && parentListItemObj.folder_id === listItemObjToAdd.id)
                                                        ||
                                                        (parentListItemObj.list_item_type === 'folder' && parentListItemObj.parent_folder_id === listItemObjToAdd.id)
                                                    );

                                                    if (!isSameFolder) {
                                                        const selectFolderContainerEl = document.createElement('div');
                                                        selectFolderContainerEl.classList.add('select-folder-container');

                                                        const selectFolderLinkEl = this.Components.SelectFolderLink.createEl(
                                                            parentListItemObj,
                                                            listItemObjToAdd,
                                                            function (listItemObj, selectedFolderListItemObj) {
                                                                window.App.Components.FolderContentList
                                                                    .Components.ListItem
                                                                        .Components.ChooseFolderOverlay.moveListItem(listItemObj, selectedFolderListItemObj.id);
                                                            }
                                                        );

                                                        selectFolderContainerEl.appendChild(selectFolderLinkEl);
                                                        folderEl.appendChild(selectFolderContainerEl);
                                                    }

                                                    foldersListEl.appendChild(folderEl);

                                                },
                                                fetchFoldersInFolder: function (folderId, listItemObj) {
                                                    var xhr = new XMLHttpRequest();
                                                    xhr.withCredentials = true;

                                                    this.clearListItems(listItemObj);
                                                    window.App.Components.FolderContentList
                                                                    .Components.ListItem
                                                                        .Components.ChooseFolderOverlay
                                                                            .Components.SelectCurrentFolderLink.hide(listItemObj);

                                                    window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                            .Components.ChooseFolderOverlay
                                                                .Components.LoadingStatus.show(
                                                                    //TODO: translate:
                                                                    'Fetching folders.. please wait',
                                                                    listItemObj
                                                                );

                                                    const $this = this;
                                                    xhr.addEventListener("readystatechange", function() {
                                                        if(this.readyState === 4) {
                                                            window.App.Components.FolderContentList
                                                                .Components.ListItem
                                                                    .Components.ChooseFolderOverlay
                                                                        .Components.LoadingStatus.hide(listItemObj);

                                                            if (
                                                                !(
                                                                    listItemObj.list_item_type === 'task'
                                                                    &&
                                                                    listItemObj.folder_id == folderId
                                                                )
                                                                &&
                                                                !(
                                                                    listItemObj.list_item_type === 'folder'
                                                                    &&
                                                                    listItemObj.parent_folder_id == folderId
                                                                )
                                                            ) {
                                                                window.App.Components.FolderContentList
                                                                    .Components.ListItem
                                                                        .Components.ChooseFolderOverlay
                                                                            .Components.SelectCurrentFolderLink.show(listItemObj);
                                                            }

                                                            try {
                                                                const folderContentJson = JSON.parse(this.responseText);
                                                                /* window.App.Components.FolderBreadcrumbs.showMainEl(
                                                                    folderContentJson.parent_folders
                                                                ); */
                                                                $this.show(listItemObj);

                                                                if (
                                                                    typeof folderContentJson.parent_folders !== 'undefined'
                                                                ) {
                                                                    window.App.Components.FolderBreadcrumbs.show(
                                                                        window.App.Components.FolderContentList
                                                                            .Components.ListItem
                                                                                .Components.ChooseFolderOverlay
                                                                                    .Components.FolderBreadcrumbs.getElId(listItemObj),
                                                                        folderContentJson.parent_folders,
                                                                        function (folderId) {
                                                                            $this.switchToFolder(folderId, listItemObj);
                                                                        }
                                                                    );

                                                                }

                                                                // add folders last
                                                                for(var i = 0; i < folderContentJson.folders.length; i++) {
                                                                    const listItemObjToAdd = folderContentJson.folders[i];
                                                                    listItemObjToAdd.list_item_type = 'folder';

                                                                    if (
                                                                        listItemObjToAdd.id === listItemObj.id
                                                                        &&
                                                                        listItemObjToAdd.list_item_type === listItemObj.list_item_type
                                                                    ) {
                                                                        continue;
                                                                    }

                                                                    $this.addListItem(
                                                                        listItemObj,
                                                                        listItemObjToAdd
                                                                    );
                                                                }

                                                                if (
                                                                    folderContentJson.folders.length === 0
                                                                ) {

                                                                    window.App.Components.FolderContentList
                                                                    .Components.ListItem
                                                                        .Components.ChooseFolderOverlay
                                                                            .Components.LoadingStatus.show(
                                                                                //TODO: translate:
                                                                                'This folder contains no folders',
                                                                                listItemObj
                                                                            );
                                                                }

                                                            } catch (error) {
                                                                // TODO: notify could not fetch/list folder content ( unexpected invalid json response )
                                                            }
                                                        }
                                                    });

                                                    var urlStr = this.api;
                                                    const currentFolderId = this.getCurrentFolderId(listItemObj);
                                                    if (currentFolderId != null) {
                                                        urlStr += '?folder=' + currentFolderId;
                                                    } else if (folderId != null) {
                                                        urlStr += '?folder=' + folderId;
                                                    }

                                                    xhr.open("POST", urlStr);

                                                    xhr.send();
                                                },
                                                Components: {
                                                    SelectFolderLink: {
                                                        createEl: function (listItemObj, selectedFolderListItemObj, selectFolderFunc) {
                                                            const selectFolderLinkEl = document.createElement('div');
                                                            selectFolderLinkEl.classList.add('select-folder-link');
                                                            selectFolderLinkEl.innerText = 'select folder'; //TODO: translate

                                                            const $this = this;
                                                            selectFolderLinkEl.onclick = function (e) {
                                                                if (
                                                                    typeof selectFolderFunc === 'function'
                                                                ) {
                                                                    selectFolderFunc(listItemObj, selectedFolderListItemObj);
                                                                }
                                                            };

                                                            return selectFolderLinkEl;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    TimeInteraction: {
                                        apis: {
                                            start: "{{ url('/api/tasks/time-interaction/start') }}",
                                            end: "{{ url('/api/tasks/time-interaction/end') }}"
                                        },
                                        runningTasks: [],
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
                                                const $this = this;
                                                const playButton = this.Components.PlayButton.createEl(
                                                    listItemObj,
                                                    function (e) {
                                                        $this.startTimeInteraction(listItemObj);
                                                    },
                                                    function (listItemObjParam) {
                                                        $this.addRunningTask(listItemObjParam);
                                                    }
                                                );
                                                const pauseButton = this.Components.PauseButton.createEl(
                                                    listItemObj,
                                                    function (e) {
                                                        $this.endTimeInteraction(listItemObj);
                                                    }
                                                );

                                                timeInteraction.appendChild(playButton);
                                                timeInteraction.appendChild(pauseButton);
                                            } else {
                                                timeInteraction.style.display = 'none';
                                            }

                                            return timeInteraction;
                                        },
                                        addRunningTask: function (listItemObj) {
                                            this.runningTasks.push(listItemObj);
                                        },
                                        visuallyStartTaskTimer: function (listItemObj, isMultiTaskingAllowed = false) {
                                            if (false === isMultiTaskingAllowed) {
                                                this.stopAllTaskTimers();
                                            }

                                            this.Components.PauseButton.show(listItemObj);
                                            this.Components.PlayButton.hide(listItemObj);
                                            this.addRunningTask(listItemObj);
                                        },
                                        visuallyStopTaskTimer: function (listItemObj) {
                                            for(var i = 0; i < this.runningTasks.length; i++) {
                                                const runningTask = this.runningTasks[i];
                                                if(
                                                    runningTask.list_item_type === listItemObj.list_item_type
                                                    &&
                                                    runningTask.id === listItemObj.id
                                                ) {
                                                    this.Components.PauseButton.hide(runningTask);
                                                    this.Components.PlayButton.show(runningTask);
                                                    this.runningTasks.splice(i, 1);
                                                    return;
                                                }
                                            }
                                        },
                                        stopAllTaskTimers: function () {
                                            for(var i = 0; i < this.runningTasks.length; i++) {
                                                const runningTask = this.runningTasks[i];
                                                this.Components.PauseButton.hide(runningTask);
                                                this.Components.PlayButton.show(runningTask);
                                            }
                                            this.runningTasks = [];
                                        },
                                        startTimeInteraction: function (listItemObj) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.withCredentials = true;

                                            window.App.Components.FolderContentList
                                                .Components.ListItem
                                                    .Components.InfoOverlay.showInfoMessage(
                                                        window.Translation.task.starting_timer,
                                                        listItemObj
                                                    );

                                            const $this = this;
                                            xhr.addEventListener("readystatechange", function() {
                                                if(this.readyState === 4) {

                                                    window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                        .Components.InfoOverlay.hide(listItemObj);

                                                    if ( this.status === 201 ) {
                                                        $this.visuallyStartTaskTimer(listItemObj);

                                                        if ( window.App.Components.RunningTasks.isVisible() ) {
                                                            window.App.Components.RunningTasks.refresh();
                                                        }
                                                        return;
                                                    }
                                                }
                                            });

                                            xhr.open("POST", this.apis.start + '?task_id=' + listItemObj.id);
                                            xhr.send();
                                        },
                                        endTimeInteraction: function (listItemObj) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.withCredentials = true;

                                            window.App.Components.FolderContentList
                                            .Components.ListItem
                                            .Components.InfoOverlay.showInfoMessage(
                                                window.Translation.task.stopping_timer,
                                                listItemObj
                                            );

                                            const $this = this;
                                            xhr.addEventListener("readystatechange", function() {
                                                if(this.readyState === 4) {

                                                    window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                        .Components.InfoOverlay.hide(listItemObj);

                                                    if ( this.status === 200 ) {
                                                        $this.visuallyStopTaskTimer(listItemObj);

                                                        if ( window.App.Components.RunningTasks.isVisible() ) {
                                                            window.App.Components.RunningTasks.refresh();
                                                        }
                                                        return;
                                                    }
                                                }
                                            });

                                            xhr.open("POST", this.apis.end + '?task_id=' + listItemObj.id);
                                            xhr.send();
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
                                        Components: {
                                            PlayButton: {
                                                getElId: function (listItemObj) {
                                                    return 'li-time-interaction-start-' + listItemObj.list_item_type + '-' + listItemObj.id;
                                                },
                                                getEl: function (listItemObj) {
                                                    return document.getElementById(this.getElId(listItemObj));
                                                },
                                                createEl: function (listItemObj, onclickEvent, callbackWhenTimerIsRunning) {
                                                    const playButton = document.createElement('div');
                                                    playButton.classList.add('play');
                                                    playButton.setAttribute(
                                                        'id',
                                                        this.getElId(listItemObj)
                                                    );

                                                    if (
                                                        listItemObj.is_timer_running == true
                                                    ) {
                                                        playButton.style.display = 'none';
                                                        if (typeof callbackWhenTimerIsRunning === 'function') {
                                                            callbackWhenTimerIsRunning(listItemObj);
                                                        }
                                                    }

                                                    if (typeof onclickEvent !== 'undefined') {
                                                        playButton.onclick = onclickEvent;
                                                    }

                                                    return playButton;
                                                },
                                                hide: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'none';
                                                },
                                                show: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'inline-block';
                                                },
                                            },
                                            PauseButton: {
                                                getElId: function (listItemObj) {
                                                    return 'li-time-interaction-end-' + listItemObj.list_item_type + '-' + listItemObj.id;
                                                },
                                                getEl: function (listItemObj) {
                                                    return document.getElementById(this.getElId(listItemObj));
                                                },
                                                createEl: function (listItemObj, onclickEvent) {
                                                    const pauseButton = document.createElement('div');
                                                    pauseButton.classList.add('pause');
                                                    pauseButton.setAttribute(
                                                        'id',
                                                        this.getElId(listItemObj)
                                                    );

                                                    if (
                                                        listItemObj.is_timer_running == false
                                                    ) {
                                                        pauseButton.style.display = 'none';
                                                    }

                                                    const pauseCol1 = document.createElement('div');
                                                    pauseCol1.classList.add('pause-col');

                                                    const pauseCol2 = document.createElement('div');
                                                    pauseCol2.classList.add('pause-col');

                                                    pauseButton.appendChild(pauseCol1);
                                                    pauseButton.appendChild(pauseCol2);

                                                    if (typeof onclickEvent !== 'undefined') {
                                                        pauseButton.onclick = onclickEvent;
                                                    }

                                                    return pauseButton;
                                                },
                                                hide: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'none';
                                                },
                                                show: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'inline-block';
                                                },
                                            }
                                        }
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
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                                .Components.ItemOptions
                                                                    .Components.Menu.toggleShow(
                                                                        listItemObj,
                                                                        [
                                                                            listItemOptions,
                                                                            optionDot1,
                                                                            optionDot2,
                                                                            optionDot3
                                                                        ]
                                                                    );
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

                                                    this.renderRootMenuForListItem(listItemObj, listItemOptionsMenuEl);

                                                    return listItemOptionsMenuEl;
                                                },
                                                hide: function (listItemObj) {
                                                    this.getEl(listItemObj).style.display = 'none';
                                                },
                                                toggleShow: function (listItemObj, hideOnClickOutsideElementExceptions = []) {
                                                    const menuEl = this.getEl(listItemObj);
                                                    if (menuEl.style.display === 'block') {
                                                        menuEl.style.display = 'none';
                                                    } else {
                                                        menuEl.style.display = 'block';
                                                        window.App.Helpers.hideOnClickOutsideElement(
                                                            menuEl,
                                                            hideOnClickOutsideElementExceptions
                                                        );
                                                    }
                                                },
                                                renderRootMenuForListItem: function (listItemObj, listItemOptionsMenuEl) {
                                                    if (
                                                        typeof listItemOptionsMenuEl === 'undefined'
                                                    ) {
                                                        listItemOptionsMenuEl = this.getEl(listItemObj);
                                                    }

                                                    switch (listItemObj.list_item_type) {
                                                        case 'task':
                                                            this.renderRootMenuItemsForTask(listItemOptionsMenuEl, listItemObj);
                                                            break;
                                                        case 'folder':
                                                            this.renderRootMenuItemsForFolder(listItemOptionsMenuEl, listItemObj);
                                                            break;
                                                    }
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
                                                renderRootMenuItemsForTask: function (listItemOptionsMenuEl, listItemObj) {
                                                    const editListItemTitleMenuItemEl = this.createEditListItemTitleMenuItemEl(listItemObj);

                                                    const moveListItemToDifferentFolderMenuItemEl = this.createMoveListItemToDifferentFolderMenuItemEl(listItemOptionsMenuEl, listItemObj);

                                                    const markCompletedMenuItemEl = this.createChangeListItemStatusMenuItemEl(
                                                        window.Translation.mark_as_completed,
                                                        'green',
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemStatus.statuses.task.COMPLETED,
                                                        listItemObj
                                                    );

                                                    const markOnHoldMenuItemEl = this.createChangeListItemStatusMenuItemEl(
                                                        window.Translation.mark_as_on_hold,
                                                        'old-moss-green',
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemStatus.statuses.task.ON_HOLD,
                                                        listItemObj
                                                    );

                                                    const markDeprecatedMenuItemEl = this.createChangeListItemStatusMenuItemEl(
                                                        window.Translation.mark_as_deprecated,
                                                        'gray',
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemStatus.statuses.task.DEPRECATED,
                                                        listItemObj
                                                    );

                                                    const deleteMenuItemEl =  this.createChangeListItemStatusMenuItemEl(
                                                        window.Translation[listItemObj.list_item_type].delete,
                                                        'red',
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemStatus.statuses.task.DELETED,
                                                        listItemObj
                                                    );

                                                    listItemOptionsMenuEl.innerHTML = '';
                                                    listItemOptionsMenuEl.appendChild(editListItemTitleMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(moveListItemToDifferentFolderMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(markCompletedMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(markOnHoldMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(markDeprecatedMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(deleteMenuItemEl);
                                                },
                                                renderRootMenuItemsForFolder: function (listItemOptionsMenuEl, listItemObj) {
                                                    const editListItemTitleMenuItemEl = this.createEditListItemTitleMenuItemEl(listItemObj);

                                                    const moveListItemToDifferentFolderMenuItemEl = this.createMoveListItemToDifferentFolderMenuItemEl(listItemOptionsMenuEl, listItemObj);

                                                    const deleteMenuItemEl =  this.createChangeListItemStatusMenuItemEl(
                                                        window.Translation[listItemObj.list_item_type].delete,
                                                        'red',
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemStatus.statuses.folder.DELETED,
                                                        listItemObj
                                                    );

                                                    listItemOptionsMenuEl.innerHTML = '';
                                                    listItemOptionsMenuEl.appendChild(editListItemTitleMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(moveListItemToDifferentFolderMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(deleteMenuItemEl);
                                                },
                                                renderEditingListItemTitleMenuItems: function (listItemOptionsMenuEl, listItemObj) {
                                                    const saveListItemTitleMenuItemEl = this.createSaveListItemTitleMenuItemEl(listItemOptionsMenuEl, listItemObj);
                                                    const cancelEditListItemTitleMenuItemEl = this.createCancelEditListItemTitleMenuItemEl(listItemOptionsMenuEl, listItemObj);

                                                    listItemOptionsMenuEl.innerHTML = '';
                                                    listItemOptionsMenuEl.appendChild(saveListItemTitleMenuItemEl);
                                                    listItemOptionsMenuEl.appendChild(cancelEditListItemTitleMenuItemEl);
                                                },
                                                createEditListItemTitleMenuItemEl: function (listItemObj) {
                                                    const editListItemTitleMenuItemEl = this.createMenuItemEl(window.Translation[listItemObj.list_item_type].edit);

                                                    const $this = this;
                                                    editListItemTitleMenuItemEl.onclick = function (e) {
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem.enableEditTitleMode(listItemObj);
                                                    };
                                                    return editListItemTitleMenuItemEl;
                                                },
                                                createSaveListItemTitleMenuItemEl: function (listItemOptionsMenuEl, listItemObj) {
                                                    const saveMenuItemEl = this.createMenuItemEl(window.Translation[listItemObj.list_item_type].save, 'green');
                                                    const $this = this;
                                                    saveMenuItemEl.onclick = function (e) {

                                                        const textareaEl = window.App.Components.FolderContentList
                                                                            .Components.ListItem
                                                                                .Components.ItemTitle.getTextareaEl(listItemObj);

                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemTitle.saveTitle(
                                                                textareaEl.value,
                                                                listItemObj,
                                                                function (newTitle, listItemObjParam) {
                                                                    listItemObjParam.title = newTitle;

                                                                    window.App.Components.FolderContentList
                                                                        .Components.ListItem
                                                                        .Components.ItemTitle.disableEditMode(listItemObjParam);
                                                                }
                                                            );

                                                        $this.renderRootMenuForListItem(listItemObj, listItemOptionsMenuEl);
                                                    };
                                                    return saveMenuItemEl;
                                                },
                                                createCancelEditListItemTitleMenuItemEl: function (listItemOptionsMenuEl, listItemObj) {
                                                    const cancelMenuItemEl = this.createMenuItemEl(window.Translation[listItemObj.list_item_type].cancel, 'red');
                                                    const $this = this;
                                                    cancelMenuItemEl.onclick = function (e) {
                                                        listItemOptionsMenuEl.style.display = 'none';

                                                        window.App.Components.FolderContentList
                                                                        .Components.ListItem
                                                                        .Components.ItemTitle.disableEditMode(listItemObj);

                                                        $this.renderRootMenuForListItem(listItemObj, listItemOptionsMenuEl);
                                                    };
                                                    return cancelMenuItemEl;
                                                },
                                                createMoveListItemToDifferentFolderMenuItemEl: function (listItemOptionsMenuEl, listItemObj) {
                                                    const moveListItemToDifferentFolderMenuItemEl = this.createMenuItemEl(
                                                        window.Translation[listItemObj.list_item_type].move
                                                    );

                                                    const $this = this;
                                                    moveListItemToDifferentFolderMenuItemEl.onclick = function (e) {
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                                .Components.ChooseFolderOverlay.show(listItemObj);

                                                        listItemOptionsMenuEl.style.display = 'none';
                                                    };
                                                    return moveListItemToDifferentFolderMenuItemEl;
                                                },
                                                createChangeListItemStatusMenuItemEl: function (menuItemText, colorClass, newStatusId, listItemObj) {
                                                    const menuItemEl = this.createMenuItemEl(
                                                        menuItemText,
                                                        colorClass
                                                    );

                                                    menuItemEl.onclick = function (e) {
                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemOptions.Components.Menu.hide(listItemObj);

                                                        window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.ItemStatus.setStatus(
                                                                newStatusId,
                                                                listItemObj,
                                                                function (new_status_id, listItemObj) {
                                                                    window.App.Components.FolderContentList
                                                                    .Components.ListItem.getEl(listItemObj).remove();
                                                                }
                                                            )
                                                    };

                                                    return menuItemEl;
                                                }
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
                                        api: {
                                            task: "{{ url('/api/tasks/edit-name') }}",
                                            folder: "{{ url('/api/folders/edit-name') }}"
                                        },
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

                                            listItemTitleTextEl.innerText = listItemObj.title;

                                            switch (listItemObj.list_item_type) {
                                                case 'task':
                                                    break;
                                                case 'folder':
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

                                            var listItemTitleMaxlength = 255;
                                            switch (listItemObj.list_item_type) {
                                                case 'task':
                                                    listItemTitleMaxlength = 2048;
                                                    break;
                                                case 'folder':
                                                    listItemTitleMaxlength = 255;
                                                    break;
                                            }

                                            const listItemTitleInputEl = window.App.Helpers.createTextarea(
                                                this.getTextareaElId(listItemObj),
                                                listItemObj.title
                                            );
                                            //TODO: Max length of list-item should be equal to allowed in db
                                           listItemTitleInputEl.setAttribute('maxlength', listItemTitleMaxlength);

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
                                            .Components.InfoOverlay.showInfoMessage(
                                                window.Translation.saving_changes,
                                                listItemObj
                                            );

                                            const $this = this;
                                            xhr.addEventListener("readystatechange", function() {
                                                if(
                                                    this.readyState === 4
                                                ) {
                                                    window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                        .Components.InfoOverlay.hide(listItemObj);

                                                    if ( this.status === 200 ) {
                                                        if (
                                                            typeof onSaveCallback === 'function'
                                                        ) {
                                                            onSaveCallback(newTitle, listItemObj);
                                                        }
                                                        return;
                                                    }

                                                    try {
                                                        const jsonRes = JSON.parse(this.responseText);

                                                        if (
                                                            typeof jsonRes.message !== 'undefined'
                                                        ) {
                                                            window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.InfoOverlay.showErrorMessage(
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
                                                        .Components.InfoOverlay.showErrorMessage(
                                                            window.Translation.saving_changes_failed,
                                                            listItemObj,
                                                            function () {
                                                                $this.getTextareaEl(listItemObj).focus();
                                                            }
                                                        );
                                                }
                                            });


                                            xhr.open("POST", this.api[listItemObj.list_item_type], true);
                                            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                                            const reqObj = {
                                                id: listItemObj.id,
                                                name: newTitle
                                            };

                                            xhr.send(JSON.stringify(reqObj));

                                        }
                                    },
                                    ItemStatus: {
                                        api: {
                                            task: "{{ url('/api/tasks/set-status') }}",
                                            folder: "{{ url('/api/folders/set-status') }}",
                                        },
                                        statuses: {
                                            task: {
                                                ACTIVE: 1,
                                                DELETED: 666,
                                                COMPLETED: 777,
                                                ON_HOLD: 999,
                                                DEPRECATED: 404
                                            },
                                            folder: {
                                                ACTIVE: 1,
                                                DELETED: 666,
                                            }
                                        },
                                        setStatus: function (new_status_id, listItemObj, onSaveCallback) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.withCredentials = true;

                                            //TODO: change:
                                            window.App.Components.FolderContentList
                                            .Components.ListItem
                                            .Components.InfoOverlay.showInfoMessage(
                                                window.Translation.saving_changes,
                                                listItemObj
                                            );

                                            const $this = this;
                                            xhr.addEventListener("readystatechange", function() {
                                                if(
                                                    this.readyState === 4
                                                ) {
                                                    window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                        .Components.InfoOverlay.hide(listItemObj);

                                                    if ( this.status === 200 ) {
                                                        if (
                                                            typeof onSaveCallback === 'function'
                                                        ) {
                                                            onSaveCallback(new_status_id, listItemObj);
                                                        }
                                                        return;
                                                    }

                                                    try {
                                                        const jsonRes = JSON.parse(this.responseText);

                                                        if (
                                                            typeof jsonRes.message !== 'undefined'
                                                        ) {
                                                            window.App.Components.FolderContentList
                                                            .Components.ListItem
                                                            .Components.InfoOverlay.showErrorMessage(
                                                                jsonRes.message,
                                                                listItemObj
                                                            );
                                                            return;
                                                        }
                                                    } catch (error) {}

                                                    //TODO: change
                                                    window.App.Components.FolderContentList
                                                        .Components.ListItem
                                                        .Components.InfoOverlay.showErrorMessage(
                                                            window.Translation.saving_changes_failed,
                                                            listItemObj
                                                        );
                                                }
                                            });


                                            xhr.open("POST", this.api[listItemObj.list_item_type], true);
                                            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                                            const reqObj = {
                                                id: listItemObj.id,
                                                new_status_id: new_status_id
                                            };

                                            xhr.send(JSON.stringify(reqObj));
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

                                                parentFolderEl.onclick = function (e) {
                                                    window.App.Views.FolderContent.switchToFolder(parentFolder.id);
                                                };

                                                if (
                                                    (i+1) < listItemObj.parent_folders.length
                                                ) {
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

                                            if (
                                                typeof listItemObj.tags !== undefined
                                                &&
                                                Array.isArray(listItemObj.tags)
                                            ) {
                                                for(var i = 0; i < listItemObj.tags.length; i++) {
                                                    const tag = listItemObj.tags[i];
                                                    const tagName = tag.name;
                                                    const tagEl = document.createElement('span');
                                                    tagEl.innerText = tagName;

                                                    tags.appendChild(tagEl);
                                                }
                                            }


                                            return tags;
                                        }
                                    }
                                }
                            }
                        },
                    },
                    AuthForm: {
                        el: function () {
                            return document.getElementById('login-form');
                        },
                        show: function (authType) {
                            if (authType === 'login') {
                                this.Components.RegisterLink.show();
                                this.Components.LoginLink.hide();
                            }

                            if (authType === 'register') {
                                this.Components.RegisterLink.hide();
                                this.Components.LoginLink.show();
                            }

                            this.el().style.display = 'block';
                        },
                        hide: function () {
                            this.el().style.display = 'none';
                        },
                        Components: {
                            LoginLink: {
                                el: function () {
                                    return document.getElementById('auth-link-to-login');
                                },
                                show: function () {
                                    this.el().style.display = 'block';
                                },
                                hide: function () {
                                    this.el().style.display = 'none';
                                }
                            },
                            RegisterLink: {
                                el: function () {
                                    return document.getElementById('auth-link-to-register');
                                },
                                show: function () {
                                    this.el().style.display = 'block';
                                },
                                hide: function () {
                                    this.el().style.display = 'none';
                                }
                            },
                        }
                    }
                },
                Views: {
                    Login: {
                        show: function() {
                            window.App.Components.AppHeader.show();
                            window.App.Components.AuthForm.show('login');
                        },
                    },
                    Register: {
                        show: function() {
                            window.App.Components.AppHeader.show();
                            window.App.Components.AuthForm.show('register');
                        },
                    },
                    FolderContent: {
                        api: "{{ url('/api/folder-content/list') }}",
                        currentFolderId: null,
                        show: function () {
                            window.App.Components.AppHeader.show();
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
                                        window.App.Components.FolderBreadcrumbs.showMainEl(
                                            folderContentJson.parent_folders
                                        );
                                        window.App.Components.FolderContentList.show();

                                        if (folderContentJson.current_folder_id !== null) {
                                            window.history.pushState(null, 'Task Manager', '?folder=' + folderContentJson.current_folder_id);
                                        } else {
                                            window.history.pushState(null, 'Task Manager', '/');
                                        }

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

                                        if (
                                            folderContentJson.tasks.length === 0
                                            &&
                                            folderContentJson.folders.length === 0
                                        ) {
                                            window.App.Components.LoadingStatus.show(
                                                window.Translation.folder_is_empty
                                            );
                                        }

                                    } catch (error) {
                                        // TODO: notify could not fetch/list folder content ( unexpected invalid json response )
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
            <div id="app-header" class="app-header"></div>

            <div id="login-form" style="display: none">
                <h1>Welcome</h1>
                <p>Please login to continue</p>

                <div class="form">
                    <form
                        method="POST"
                        action="{{ route('loginAttempt') }}"
                        name="authForm"
                    >
                        @csrf
                        <input type="submit" style="display: none" />
                        <div>
                            <div class="label">Username</div>
                            <input type="text" name="username" id="login-username">
                        </div>
                        <div>
                            <div class="label">Password</div>
                            <input type="password" name="password" id="login-password">
                        </div>

                        @if(!empty($authErrorMsg))
                            <div class="error-feedback">
                                {{ $authErrorMsg }}
                            </div>
                        @endif

                        <div class="buttons">
                            <div
                                class="btn btn-simple-white"
                                onclick="window.App.Auth.submitLoginForm();">
                                Login
                            </div>
                            <div class="link-container">
                                <a
                                    href="{{ route('register') }}"
                                    id="auth-link-to-register"
                                    style="display: none">
                                    I don't have an account yet
                                </a>
                                <a
                                    href="{{ route('login') }}"
                                    id="auth-link-to-login"
                                    style="display: none">
                                    I already have an account
                                </a>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="running-tasks" id="running-tasks" style="display: none">
                <div class="header">
                    <svg style="color: rgb(31, 57, 66);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16"> <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z" fill="#1f3942"></path> <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z" fill="#1f3942"></path> </svg>
                    <span>Currently working on..</span>
                    <div id="close-running-tasks" class="close-btn">X</div>
                </div>
                <div class="loading-status" id="loading-status-rtl" style="display: none"></div>
                <div class="list" id="running-tasks-list"></div>
            </div>
            <div class="folder-breadcrumbs" id="folder-breadcrumbs" style="display: none"></div>
            <div class="loading-status" id="loading-status" style="display: none"></div>
            <div class="list" id="folder-content-list" style="display: none"></div>
        </div>


        @if(isset($view))
            <script>
                window.App.currentView = '{{ $view }}';
            </script>
        @endif

        @if(
            isset($view) && $view === 'FolderContent'
            &&
            isset($folder)
        )
            <script>
                window.App.Views.FolderContent.setCurrentFolderId('{{ $folder }}');
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
