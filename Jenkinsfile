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

        stage('Check Running Containers') {
            steps {
                sh 'docker ps'
            }
        }

        stage('Pipeline Success') {
            steps {
                sh 'echo CI/CD Pipeline Executed Successfully'
            }
        }
    }
}
