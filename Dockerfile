FROM php:latest

RUN apt update &&\
    apt install nodejs

COPY . /usr/src/app
