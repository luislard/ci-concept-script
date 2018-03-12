pipeline {
    agent any
    stages {
        stage('Stage 1: Download Docker Repo') {
            steps {
                build job: 'ci-concept-docker'
                echo 'Docker repo was Downloaded'
            }
        }
        stage('Stage 2: Starting docker containers') {
            steps {
                dir ('../ci-concept-docker') {
                  sh './develop up -d'
                }
            }
        }
        stage('Stage 3: Installing Project Dependencies') {
            steps {
                dir ('../ci-concept-docker') {
                  sh './develop composer install'
                }
            }
        }
        stage('Stage 4: Running PHPUnit tests') {
            steps {
                dir ('../ci-concept-docker') {
                  sh './develop t ./tests'
                }
            }
        }
    }
}
