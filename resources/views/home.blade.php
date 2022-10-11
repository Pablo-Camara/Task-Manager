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

            .task-list {

            }

            .task-list .task-item {
                padding: 14px 0 14px 0;
                border-bottom: 1px dashed rgba(70, 107, 119, 0.44);
                position: relative;
            }


            .task-list .task-item .time-interaction {
                height: 20px;
                width: 30px;
                position: absolute;
                left: 5px;
                text-align: center;
            }

            .task-list .task-item .time-interaction .play {
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 10px 0 10px 17.3px;
                border-color: transparent transparent transparent #ffffff;
                display: inline-block;
                cursor: pointer;
            }

            .task-list .task-item .time-interaction .pause {
                width: 100%;
                height: 100%;
                text-align: center;
                display: inline-block;
                cursor: pointer;
            }

            .task-list .task-item .time-interaction .pause .pause-col {
                height: 100%;
                width: 4px;
                background: #FFFFFF;
                display: inline-block;
            }

            .task-list .task-item .time-interaction .pause .pause-col:first-child {
                margin-right: 5px;
            }

            .task-list .task-item .task-title {
                color: #FFFFFF;
                font-size: 14px;
                padding-left: 40px;
                padding-right: 30px;
            }

            .task-list .task-item .task-options {
                position: absolute;
                right: 0;
                height: 30px;
                width: 30px;
                cursor: pointer;
            }


            .task-list .task-item .task-options .option-dot {
                height: 8px;
                width: 8px;
                background: #FFFFFF;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                border-radius: 8px;
                margin: auto;
                margin-bottom: 2px;
            }

            .task-list .task-item .time-spent {
                color: rgba(255, 198, 2, 0.76);
                text-align: left;
                font-size: 12px;
                margin-top: 10px;

                padding-left: 40px;
                padding-right: 30px;
            }

            .task-list .task-item .folder {
                color: #7a9fa4;
                text-align: left;
                font-size: 12px;
                margin-top: 10px;
                padding-left: 40px;
                padding-right: 30px;
            }

            .task-list .task-item .folder .breadcrumb {
                margin-left: 6px;
                margin-right: 6px;
                color: #FFFFFF;
                font-size: 12px;
            }

            .task-list .task-item .tags {
                text-align: right;
                margin-top: 10px;
            }

            .task-list .task-item .tags span {
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
            window.App = {
                Helpers: {
                    getVerticalCenter: function (elementHeight, containerHeight) {
                        return (containerHeight/2)-(elementHeight/2);
                    }
                },
                Components: {
                    TaskList: {
                        el: function () {
                            return document.getElementById('task-list');
                        },
                        addTask: function (task) {
                            const newTask = this.Components.Task.createEl(task);
                            this.el().appendChild(newTask.taskItemEl);

                            // center time interaction vertically
                            const timeInteractionYPos = window.App.Helpers.getVerticalCenter(
                                newTask.timeInteractionEl.offsetHeight,
                                newTask.taskItemEl.offsetHeight
                            );
                            newTask.timeInteractionEl.style.top = timeInteractionYPos + 'px';

                            // center task options 3 dots btn vertically
                            const taskOptionsBtnYPos = window.App.Helpers.getVerticalCenter(
                                newTask.taskOptionsEl.offsetHeight,
                                newTask.taskItemEl.offsetHeight
                            );
                            newTask.taskOptionsEl.style.top = taskOptionsBtnYPos + 'px';
                        },
                        Components: {
                            Task: {
                                createEl: function (task) {
                                    const taskItem = document.createElement('div');
                                    taskItem.classList.add('task-item');

                                    const timeInteraction = this.createTimeInteractionButtonEl(task);
                                    const taskOptions = this.createTaskOptionsEl(task);
                                    const taskTitle = this.createTaskTitleEl(task);
                                    const timeSpent = this.createTimeSpentEl(task);
                                    const parentFolders = this.createParentFoldersEl(task);
                                    const tags = this.createTagsEl(task);

                                    taskItem.appendChild(timeInteraction);
                                    taskItem.appendChild(taskOptions);
                                    taskItem.appendChild(taskTitle);
                                    taskItem.appendChild(timeSpent);
                                    taskItem.appendChild(parentFolders);
                                    taskItem.appendChild(tags);

                                    return {
                                        taskItemEl: taskItem,
                                        timeInteractionEl: timeInteraction,
                                        taskTitleEl: taskTitle,
                                        taskOptionsEl: taskOptions
                                    };
                                },
                                createTimeInteractionButtonEl: function (task) {
                                    const timeInteraction = document.createElement('div');
                                    timeInteraction.classList.add('time-interaction');

                                    const playButton = this.createPlayButtonEl(task);
                                    const pauseButton = this.createPauseButtonEl(task);

                                    timeInteraction.appendChild(playButton);
                                    timeInteraction.appendChild(pauseButton);

                                    return timeInteraction;
                                },
                                createPlayButtonEl: function (task) {
                                    const playButton = document.createElement('div');
                                    playButton.classList.add('play');
                                    //playButton.style.display = 'none';
                                    return playButton;
                                },
                                createPauseButtonEl: function (task) {
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
                                createTaskOptionsEl: function (task) {
                                    const taskOptions = document.createElement('div');
                                    taskOptions.classList.add('task-options');

                                    const optionDot1 = document.createElement('div');
                                    optionDot1.classList.add('option-dot');

                                    const optionDot2 = document.createElement('div');
                                    optionDot2.classList.add('option-dot');

                                    const optionDot3 = document.createElement('div');
                                    optionDot3.classList.add('option-dot');

                                    taskOptions.appendChild(optionDot1);
                                    taskOptions.appendChild(optionDot2);
                                    taskOptions.appendChild(optionDot3);

                                    return taskOptions;
                                },
                                createTaskTitleEl: function (task) {
                                    const taskTitle = document.createElement('div');
                                    taskTitle.classList.add('task-title');
                                    taskTitle.innerText = task.title;
                                    return taskTitle;
                                },
                                createTimeSpentEl: function (task) {
                                    const timeSpent = document.createElement('div');
                                    timeSpent.classList.add('time-spent');
                                    timeSpent.innerHTML = 'time spent on this task today: <b>' + task.time_spent_today + '</b>';
                                    return timeSpent;
                                },
                                createParentFoldersEl: function (task) {
                                    const parentFolders = document.createElement('div');
                                    parentFolders.classList.add('folder');

                                    for(var i = 0; i < task.parent_folders.length; i++) {
                                        const parentFolderName = task.parent_folders[i];

                                        const parentFolderEl = document.createElement('span');
                                        parentFolderEl.innerText = parentFolderName;

                                        parentFolders.appendChild(parentFolderEl);

                                        if (
                                            (i+1) < task.parent_folders.length
                                        ) {
                                            const breadcrumb = document.createElement('span');
                                            breadcrumb.classList.add('breadcrumb');
                                            breadcrumb.innerText = '/';
                                            parentFolders.appendChild(breadcrumb);
                                        }
                                    }

                                    return parentFolders;
                                },
                                createTagsEl: function (task) {
                                    const tags = document.createElement('div');
                                    tags.classList.add('tags');

                                    for(var i = 0; i < task.tags.length; i++) {
                                        const tagName = task.tags[i];
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
                initialize: function () {
                    this.Components.TaskList.addTask({
                        title: 'Create MVP',
                        time_spent_today: '00:50:00',
                        parent_folders: ['camara.pt', 'task-manager.camara.pt'],
                        tags: ['PHP 8', 'Laravel 9', 'MySql']
                    });

                    this.Components.TaskList.addTask({
                        title: 'Allow admin to import users through CSV file (provide csv template)',
                        time_spent_today: '00:00:00',
                        parent_folders: ['camara.pt', 'Clients', 'InIdeia', 'Doc Manager'],
                        tags: ['PHP 8', 'Laravel 9', 'MySql']
                    });

                    this.Components.TaskList.addTask({
                        title: 'Translate everything to Portuguese',
                        time_spent_today: '00:00:00',
                        parent_folders: ['camara.pt', 'Clients', 'InIdeia', 'Doc Manager'],
                        tags: ['PHP 8', 'Laravel 9', 'MySql', 'Language localization']
                    });

                    this.Components.TaskList.addTask({
                        title: 'Update code with more recent code from the url shortner project',
                        time_spent_today: '00:00:00',
                        parent_folders: ['camara.pt', 'auth.camara.pt'],
                        tags: ['PHP 8', 'Laravel 9', 'MySql']
                    });

                    this.Components.TaskList.addTask({
                        title: 'Update _authManager JS',
                        time_spent_today: '00:00:00',
                        parent_folders: ['camara.pt'],
                        tags: ['JavaScript']
                    });

                    this.Components.TaskList.addTask({
                        title: 'Add shortlink_url_id to user_actions table',
                        time_spent_today: '00:00:00',
                        parent_folders: ['URL Shortner', 'Tracking'],
                        tags: ['PHP 8', 'Laravel 9', 'MySql', 'Database Structure']
                    });

                }
            };
        </script>
    </head>
    <body>
        <div id="app">
            <div class="app-title">Task Manager</div>

            <div class="task-list" id="task-list"></div>
        </div>

        <script>
            window.App.initialize();

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
        </script>
    </body>
</html>
