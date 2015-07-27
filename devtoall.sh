#!/bin/bash
# My first script

git checkout develop;
git checkout master;
git merge develop;
git checkout peak;
git merge master;
git checkout semoauto;
git merge master;
git checkout colorado;
git merge master;
git checkout wvow;
git merge master;
git checkout cjvr;
git merge master;
git push;
git checkout develop;