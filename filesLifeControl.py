import os

from time import sleep
from shutil import rmtree
from datetime import datetime


class Control(object):
    def __init__(self):
        self.path = f'{os.getcwd()}/tmp/'
        self.loop()
    
    
    def loop(self):
        while True:
            self.scan()
            
            # sleep 60 sec.
            sleep(60)
    
    
    def scan(self):
        current_time = datetime.now().timestamp()
        
        for subdir, dirs, files in os.walk(self.path):
            for _dir in dirs:
                # timestamp value
                creation_time = os.stat(self.path + _dir).st_ctime
                
                if (current_time - creation_time) >= 60:
                    self.delete(self.path + _dir)
    
    
    @staticmethod
    def delete(path: str):
        rmtree(path, ignore_errors=True)


Control()
