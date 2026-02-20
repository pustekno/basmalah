Financial Transaction, Account Management, & Calendar Module
🚨 CONTEXT NOTICE FOR AI AGENT

This is an enhancement phase of an already running Laravel application.

Existing systems already implemented:

Authentication

Role & Permission (Spatie)

Dashboard UI

Base Routing Structure

MVC Architecture

You MUST:

✅ Extend current system
❌ NOT rebuild features
❌ NOT modify authentication
❌ NOT replace dashboard UI
❌ NOT scaffold new Laravel project

🎯 OBJECTIVE

Complete the implementation of the following dependent modules:

Module	Dependency
Financial Transaction Management	Core System
Account / Cash Management	Required by Transactions
Calendar View	Depends on Transactions

All new features MUST integrate with the existing architecture.

🧩 MODULE 1 — Financial Transaction Management

Implement transaction recording system for:

Income

Zakat

Infaq

Sedekah

Donasi

Expense

Operational

Equipment

Activities

Each transaction MUST:

Be linked to an account (account_id)

Store amount as decimal string

Support manual recording only

Include proof image upload

Include optional upcoming flag

Required Fields:
Field	Type
account_id	Foreign Key
transaction_type	income / expense
category	String
amount	Decimal String
description	Text
transaction_date	Date
proof_image	File Path
upcoming_flag	Boolean
🧩 MODULE 2 — Account / Cash Management

All financial transactions MUST be attached to a specific account.

Example:

Kas Kecil

Kas Besar

Rekening Bank

System MUST support:

Multiple Accounts

Account-based transaction history

Automatic balance update

Balance Automation Rule
Transaction Type	Effect
Income	Increase Balance
Expense	Decrease Balance
Upcoming	Ignore

Transactions with:

upcoming_flag = true

MUST:

NOT update account balance

Be displayed in Calendar Module

Be stored as scheduled transaction

🧩 MODULE 3 — Calendar View

Calendar MUST:

Display transactions by transaction_date

Include:

Income

Expense

Upcoming Transactions

Fetch data dynamically from database

Backend Requirement:

Create JSON API Endpoint:

/api/calendar-transactions

Return:

title

amount

type

date

upcoming status

📷 Transaction Proof Upload

Each transaction MUST:

Accept image upload

Use Laravel Storage System

Save file path in database

💰 MONEY CALCULATION REQUIREMENT

JavaScript floating-point arithmetic is strictly prohibited.

Use:

decimal.js OR

big.js

dinero.js

For all:

Amount calculation

Account balance update

Currency handling (IDR)

🧠 DEVELOPMENT CONSTRAINTS

AI Agent MUST:

Follow Laravel MVC Pattern

Use Migration for new tables

Use Eloquent Relationship

Keep modular logic separation

Required Controllers:

AccountController

TransactionController

CalendarController

✅ IMPLEMENTATION TARGET

AI Agent must now:

Implement Account Module

Implement Transaction Module

Implement Balance Automation

Implement Upcoming Logic

Implement Proof Upload

Implement Calendar Endpoint

Link Transactions ↔ Accounts