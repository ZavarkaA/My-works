from django.urls import path
from . import views

urlpatterns = [
    path('',views.accounts_home, name='accounts_home')
]