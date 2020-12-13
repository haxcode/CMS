## Code flow DDD

Interfejs użytkownika [UI layer]
1. Poprzez REST API wywoływany jest kontroler.
2. Kontroler dokonuje kontroli spójności żądania, a następnie przekazuje żądanie do serwisu.

Aplikacja [Application layer]
3. Metoda serwisu wykonuje intencje użytkownika w postaci wygenerowania odpowiednich komend lub zapytań. 
4. Komendy nie zwracają wyniku zgodnie ze wzorcem CQRS.
5. Zapytania zwracają wyniki.
                                            
[DOMAIN]
Domena to warstwa systemu gdzie jest umieszczona logika działania, reguły spójności, obiekty dziedziny, zdarzenia emitowane przez system. 


Infrastruktura [Infrastructure layer]
6. Handler wykonuje żądaną komendę, a następnie (nie zawsze) emituje zdarzenie systemowe.
7. Obsługa komendy jest integralną operacją, która często kończy się zapisem zmienionego agregatu do bazy danych. 
