from django.db import models
from tickets.models import Ticket
from accounts.models import Employee


class Message(models.Model):
    """Сообщения в чате по заявке."""
    ticket = models.ForeignKey(
        Ticket,
        on_delete=models.CASCADE,
        related_name='messages',
        verbose_name='Заявка'
    )
    author_name = models.CharField(max_length=200, verbose_name='Автор сообщения')
    author_type = models.CharField(
        max_length=20,
        choices=[
            ('visitor', 'Посетитель'),
            ('employee', 'Сотрудник'),
        ],
        verbose_name='Тип автора'
    )
    text = models.TextField(verbose_name='Текст сообщения')
    created_at = models.DateTimeField(auto_now_add=True, verbose_name='Дата и время')
    
    class Meta:
        verbose_name = 'Сообщение'
        verbose_name_plural = 'Сообщения'
        ordering = ['created_at']
    
    def __str__(self):
        return f'{self.author_name}: {self.text[:50]}'