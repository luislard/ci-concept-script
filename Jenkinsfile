pipeline {
    agent any
    stages {
        stage('Stage 1: Download Docker Repo') {
            steps {
                build job: 'ci-concept-docker'
                echo 'Docker repo was Downloaded'
            }
        }
        stage('Stage 2: Build') {
            steps {
                dir ('../ci-concept-docker') {
                  echo 'Starting Docker Containers'
                  sh './develop up -d'
                  echo 'Installing Dependencies'
                  sh './develop composer install'
                  echo 'Running PHPUnit Tests'
                  sh './develop t ./tests'
                  echo 'Destroying Containers'
                  sh './develop down'
                }
            }
        }
    }
}
