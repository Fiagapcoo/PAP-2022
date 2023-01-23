from kivy.app import App
from kivy.lang import Builder
from kivymd.app import MDApp


class Login(MDApp):
    def build(self):
        return Builder.load_file("a2.kv")


Login().run()