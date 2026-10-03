from django.db import models
from django.contrib.auth.models import AbstractBaseUser, BaseUserManager, PermissionsMixin

class EmployeeManager(BaseUserManager):
    def create_user(self, login, password=None, **extra_fields):
        if not login:
            raise ValueError('Логин обязателен')
        user = self.model(login=login, **extra_fields)
        if password:
            user.set_password(password)
        user.save(using=self._db)
        return user
    
    def create_superuser(self, login, password=None, **extra_fields):
        extra_fields.setdefault('is_admin', True)
        extra_fields.setdefault('is_active', True)
        extra_fields.setdefault('is_staff', True)
        extra_fields.setdefault('is_superuser', True)
        return self.create_user(login, password, **extra_fields)


class Employee(AbstractBaseUser, PermissionsMixin):
    """Сотрудники техподдержки и администраторы."""
    id_employee = models.AutoField(primary_key=True)
    full_name = models.CharField(max_length=200)
    login = models.CharField(max_length=100, unique=True)
    is_admin = models.BooleanField(default=False)
    is_active = models.BooleanField(default=True)
    created_at = models.DateTimeField(auto_now_add=True)
    
    # Добавляем related_name, чтобы избежать конфликта со встроенной моделью User
    groups = models.ManyToManyField(
        'auth.Group',
        verbose_name='groups',
        blank=True,
        help_text='The groups this user belongs to.',
        related_name='employee_users',  # Уникальное имя
        related_query_name='employee_user',
    )
    user_permissions = models.ManyToManyField(
        'auth.Permission',
        verbose_name='user permissions',
        blank=True,
        help_text='Specific permissions for this user.',
        related_name='employee_users',  # Уникальное имя
        related_query_name='employee_user',
    )
    
    # Поля, которые Django Auth ожидает от AbstractBaseUser
    USERNAME_FIELD = 'login'
    REQUIRED_FIELDS = ['full_name']
    
    objects = EmployeeManager()
    
    class Meta:
        verbose_name = 'Сотрудник'
        verbose_name_plural = 'Сотрудники'
    
    def __str__(self):
        return self.full_name
    
    @property
    def is_staff(self):
        """Нужно для доступа к админке Django."""
        return self.is_admin