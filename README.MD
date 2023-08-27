# 🤖 Backend api for <a hreft="https://github.com/valb-mig/todo-web-app">Todo web app</a>
Made with laravel, the api its a backend for my current principal side project, <b>Todo.sh</b>,
the purpouse of this api is the comunication of data from the Todo.sh and for the Todo.sh.

## 🔍 Current routes

## 🧑 User

### /  
```(Return 200 if its connected)```

### /user   
keys:
- (header) token: String

```(Return user data)```

### /user/login    
keys:
- username: String
- password: String

```(Verify the user)```

### /user/register 
keys:
- username: String
- password: String

```(Insert the user)```

## 🔩 Projects 

### /project 
keys:
- (header) token: String

```(Return user projects)```

### /project/add
keys:
- (header) token: String 
- project_title:  String
- project_icon:   String
- project_type:   String | T or K
- project_days:   Int

```(Add user project)```

🏗️👷 ...Other project route features, are comming!!

## 📝 Tasks

### /task
keys:
- (header) token: String
- project_id: Int

```(Return user tasks by project)```

### /task/add
keys:
- (header) token: String 
- project_id:  Int
- task_title:  String
- task_desc:   String

```(Add user task by project)```

### /task/edit
keys:
- (header) token: String 
- project_id: Int
- task_id:    Int
- action:     String | done, not-done, edit-info

```(Edit user task based on action)```

### /task/remove
keys:
- (header) token: String 
- project_id: Int
- task_id:    Int

```(Remove/Disable user task)```