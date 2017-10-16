angular.module('epab', [])
    .controller('DossierController', function($http) {
        var $scope = this;
        $scope.dossier = {};
        $scope.dossiers = [];

        $scope.setDossier = function(dossier) {
            $scope.dossier = JSON.parse(dossier);
        }

        $scope.getLink = function(url, id) {
            return url;
        }

        $scope.init = function() {
            alert('hey');
        }
        $scope.init();

        todoList.addTodo = function() {
            $http.post('/todo/ajouter', {
                todonew: todoList.todoText,
                tododone: false
            }).then(function(res) {
                //alert(JSON.stringify(res));
                if (res.status != 'undefined' && res.status == 200) {
                    todoList.todos.push({
                        text: todoList.todoText,
                        done: false
                    });
                    todoList.todoText = '';
                }
            });
        };

        todoList.deleteTodo = function(index) {
            $http.get('/todo/supprimer/' + index).then(function(res) {
                todoList.todos.splice(index, 1);
            });
        };

        todoList.remaining = function() {
            var count = 0;
            angular.forEach(todoList.todos, function(todo) {
                count += todo.done ? 0 : 1;
            });
            return count;
        };

        todoList.archive = function() {
            var oldTodos = todoList.todos;
            todoList.todos = [];
            angular.forEach(oldTodos, function(todo) {
                if (!todo.done) todoList.todos.push(todo);
            });
        };
    });