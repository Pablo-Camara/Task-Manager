<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Task Manager</title>

        <link
            href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"
            rel="preload"
            as="style"
            onload="this.onload=null;this.rel='stylesheet';"
        />

        <style>
            html,body {
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Nunito', sans-serif;
            }

            #app {
                width: 100%;
                max-width: 320px;
                min-height: 300px;
                margin: auto;
                background: #00202b;
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
                padding: 10px 0 10px 0;
                border-bottom: 1px dashed #1f3942;
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
            }

            .task-list .task-item .time-interaction .pause {
                width: 100%;
                height: 100%;
                text-align: center;
                display: inline-block;
            }

            .task-list .task-item .time-interaction .pause .pause-col {
                height: 100%;
                width: 4px;
                background: #FFFFFF;
                display: inline-block;
            }

            .task-list .task-item .time-interaction .pause .pause-col:first-child {
                margin-right: 2px;
            }

            .task-list .task-item .task-title {
                color: #FFFFFF;
                font-size: 14px;
                padding-left: 40px;
                padding-right: 20px;
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
                        },
                        Components: {
                            Task: {
                                createEl: function (task) {
                                    const taskItem = document.createElement('div');
                                    taskItem.classList.add('task-item');

                                    const timeInteraction = this.createTimeInteractionButtonEl(task);
                                    const taskTitle = this.createTaskTitleEl(task);
                                    const taskOptions = this.createTaskOptionsEl(task);

                                    taskItem.appendChild(timeInteraction);
                                    taskItem.appendChild(taskTitle);
                                    taskItem.appendChild(taskOptions);

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
                                createTaskTitleEl: function (task) {
                                    const taskTitle = document.createElement('div');
                                    taskTitle.classList.add('task-title');
                                    taskTitle.innerText = task.title;
                                    return taskTitle;
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
                                }
                            }
                        }
                    }
                },
                initialize: function () {
                    this.Components.TaskList.addTask({
                        title: 'Some hella big task title for some hella big project with some hella big titled tasks all day long'
                    });

                    this.Components.TaskList.addTask({
                        title: 'Some task title'
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
        </script>
    </body>
</html>
