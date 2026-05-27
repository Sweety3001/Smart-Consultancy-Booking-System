pipeline {
    agent any

    stages {

        stage('Clone Project Info') {
            steps {
                sh 'pwd'
                sh 'ls -la'
            }
        }

        stage('Check Docker') {
            steps {
                sh 'docker --version'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t laravel-devops-cicd .'
            }
        }

        stage('Stop Old Container') {
            steps {
                sh '''
                docker stop laravel-cicd-container || true
                docker rm laravel-cicd-container || true
                '''
            }
        }

        stage('Deploy New Container') {
    steps {
        sh '''
        docker run -d \
        --name laravel-cicd-container \
        -p 9000:8000 \
        -e APP_KEY=base64:6VZM024DbEZ6YwMtT0l1rT3jpZOuezIhHBucT6oPcw0= DB_CONNECTION=mysql \
        -e DB_HOST=mysql_db \
        -e DB_PORT=3306 \
        -e DB_DATABASE=laravel \
        -e DB_USERNAME=root \
        -e DB_PASSWORD=root \
        --network ca2project_laravel \
        laravel-devops-cicd \
        php artisan serve --host=0.0.0.0 --port=8000
        '''
    }
}

        stage('Deployment Success') {
            steps {
                sh 'echo Laravel CI/CD Deployment Completed Successfully'
            }
        }
    }
}