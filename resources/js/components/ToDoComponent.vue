<template>
    <div>
        <input type="text" class="form-control mb-2" name="todo" v-model="newTask" @keyup.enter="addTask()" placeholder="Enter Your Task">
        <ul v-if="showTaskList.length > 0" name="" class="list-group" id="">
            <li  v-for="task in showTaskList" :key="task.id" class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <input type="checkbox" :checked="task.isComplete" class="mr-2" @click="markTaskComplete(task)" >
                        <span v-if="!task.isComplete" v-show="!task.isEdit" @click="editTaskName(task)">{{ task.taskName }}</span>
                        <input type="text" v-show="task.isEdit" class="form-control" :value="task.taskName" @keyup.enter="updateTaskName(task,$event)" >
                         <del v-if="task.isComplete" > {{ task.taskName }}</del>
                    </span>
                    <span class="badge badge-primary badge-pill" @click="deleteTask(task.id)">X</span>
            </li>
        </ul>
        <div v-if="taskList.length > 0" class="row mt-2">
            <div class="col-md-3"><label class="float-left">{{ taskList.length }} items left</label></div>
                <div class="col-md-5">
                    <Button class="btn btn-sm" @click="changeTaskListByStatus(1)">All</Button>
                    <Button class="btn btn-sm" @click="changeTaskListByStatus(2)">Active</Button>
                    <Button class="btn btn-sm" @click="changeTaskListByStatus(3)">Completed</Button>
                </div>
                <div class="col-md-4"><button class="btn btn-sm float-right" @click="clearAllTask()">Clear Completed</button></div>
        </div>

    </div>
</template>

<script>

export default {

    data () {
        return {
            id: 1,
            newTask: '',
            taskList: [],
            showTaskList:[]
        }
    },

    created(){
            Fire.$on('changedTaskList',() =>{
                this.taskListReload();
            });
    },

    methods: {

        addTask(){
            let task = {id: this.id++,taskName: this.newTask, isComplete: false }
            this.taskList.push(task);
            this.newTask = '';
            Fire.$emit('changedTaskList');
        },

        editTaskName(updateTask) {
            updateTask.isEdit = true;
            const index = this.taskList.findIndex(task => task.id === updateTask.id);

            if (index !== -1) {
                this.taskList.splice(index, 1, updateTask);
            }
            Fire.$emit('changedTaskList');
        },

        updateTaskName(updateTask,event){
            updateTask.taskName = event.target.value;
            updateTask.isEdit = false;
            const index = this.taskList.findIndex(task => task.id === updateTask.id);

            if (index !== -1) {
                this.taskList.splice(index, 1, updateTask);
            }
            Fire.$emit('changedTaskList');
        },

        taskListReload(){
              this.showTaskList = this.taskList;
        },

        changeTaskListByStatus(status){

            if(status == 2){
                this.showTaskList =  this.taskList.filter(task => task.isComplete == false);
            }else if(status == 3){
                this.showTaskList = this.taskList.filter(task => task.isComplete == true);
            }else{
                 this.showTaskList = this.taskList;
            }

        },

        deleteTask(id){
            this.taskList = this.taskList.filter(task => task.id !== id);
            Fire.$emit('changedTaskList');
        },

        markTaskComplete(updateTask){

            updateTask.isComplete = updateTask.isComplete ? false : true;
            const index = this.taskList.findIndex(task => task.id === updateTask.id);

            if (index !== -1) {
                this.taskList.splice(index, 1, updateTask);
            }
            Fire.$emit('changedTaskList');
        },

        clearAllTask(){
             this.taskList = [];
             Fire.$emit('changedTaskList');
        }
    }
}
</script>
