# Email & SMTP Configuration Guide

**Date**: January 10, 2026  
**Feature**: Custom Email Notifications & SMTP Support  
**Status**: ✅ Complete

---

## ✅ WHAT WAS ADDED

### 1. **Settings Page**
- ✅ WordPress admin settings page
- ✅ Configure notification email
- ✅ Enable/disable SMTP
- ✅ Full SMTP configuration
- ✅ Test email functionality

### 2. **SMTP Support**
- ✅ Send emails via SMTP instead of PHP mail()
- ✅ Support for Gmail, Outlook, SendGrid, etc.
- ✅ TLS/SSL encryption
- ✅ Custom From email and name

### 3. **Custom Notification Email**
- ✅ Set custom email for bug/feature reports
- ✅ Different from WordPress admin email
- ✅ Easy to change anytime

---

## 📁 FILES CREATED

1. ✅ **`inc/settings-page.php`** - Admin settings interface
2. ✅ **`inc/smtp-config.php`** - SMTP configuration handler
3. ✅ **`functions.php`** - Updated to include new files
4. ✅ **`inc/submission-handler.php`** - Updated to use custom email

---

## 🎯 HOW TO USE

### Step 1: Access Settings

1. **Go to**: WordPress Admin
2. **Click**: **Roadmap Settings** (in sidebar)
3. **You'll see**: Settings page with two sections

---

### Step 2: Configure Notification Email

**Field**: Notification Email

**Purpose**: Email address to receive bug reports and feature requests

**Example**: `bugs@designindc.com`

**Default**: WordPress admin email

**How to set**:
1. Enter your preferred email
2. Click "Save Settings"
3. Done!

---

### Step 3: Enable SMTP (Optional but Recommended)

**Why use SMTP?**
- ✅ More reliable delivery
- ✅ Better spam score
- ✅ Professional sender identity
- ✅ Delivery tracking

**When to use**:
- Your host blocks PHP mail()
- Emails going to spam
- Need reliable delivery
- Want professional sender

---

### Step 4: Configure SMTP Settings

#### Option A: Gmail

```
SMTP Host: smtp.gmail.com
SMTP Port: 587
Encryption: TLS
Username: your-email@gmail.com
Password: [App-specific password]
From Email: your-email@gmail.com
From Name: Your Company Name
```

**Gmail Setup**:
1. Enable 2-factor authentication
2. Generate app-specific password
3. Use that password (not your regular password)

---

#### Option B: Outlook/Office 365

```
SMTP Host: smtp.office365.com
SMTP Port: 587
Encryption: TLS
Username: your-email@outlook.com
Password: [Your password]
From Email: your-email@outlook.com
From Name: Your Company Name
```

---

#### Option C: SendGrid

```
SMTP Host: smtp.sendgrid.net
SMTP Port: 587
Encryption: TLS
Username: apikey
Password: [Your SendGrid API key]
From Email: verified-sender@yourdomain.com
From Name: Your Company Name
```

---

#### Option D: Custom SMTP

```
SMTP Host: [Your SMTP server]
SMTP Port: 587 (TLS) or 465 (SSL)
Encryption: TLS or SSL
Username: [Your username]
Password: [Your password]
From Email: [Verified sender email]
From Name: [Your name/company]
```

---

## 🧪 TESTING

### Test Email Function

1. **Configure SMTP settings**
2. **Click**: "Send Test Email" button
3. **Wait**: A few seconds
4. **Check**: Your notification email inbox
5. **Result**: 
   - ✅ Success: "Test email sent successfully!"
   - ❌ Error: "Failed to send test email. Check your SMTP settings."

### What to check if test fails:

1. **SMTP Host**: Correct server address?
2. **Port**: Matches encryption type?
3. **Username**: Correct email/username?
4. **Password**: Correct password/API key?
5. **From Email**: Matches SMTP account?
6. **Firewall**: Blocking outbound SMTP?

---

## 📊 SETTINGS OVERVIEW

### Notification Email
- **Purpose**: Where to send bug/feature reports
- **Default**: WordPress admin email
- **Can be**: Any valid email address
- **Example**: `bugs@designindc.com`

### SMTP Enabled
- **Purpose**: Use SMTP instead of PHP mail()
- **Default**: Disabled (uses PHP mail())
- **Recommended**: Enable for better delivery

### SMTP Host
- **Purpose**: Your SMTP server address
- **Example**: `smtp.gmail.com`
- **Required**: Yes (if SMTP enabled)

### SMTP Port
- **Purpose**: Server port number
- **Common**: 587 (TLS), 465 (SSL), 25 (None)
- **Recommended**: 587 with TLS

### Encryption
- **Options**: TLS, SSL, None
- **Recommended**: TLS (port 587)
- **Secure**: SSL (port 465)
- **Avoid**: None (unless internal network)

### SMTP Username
- **Purpose**: Login username
- **Usually**: Your email address
- **Example**: `your-email@gmail.com`

### SMTP Password
- **Purpose**: Login password
- **Gmail**: Use app-specific password
- **Others**: Regular password or API key
- **Security**: Stored in WordPress database

### From Email
- **Purpose**: Sender email address
- **Must**: Match SMTP account
- **Example**: `noreply@designindc.com`

### From Name
- **Purpose**: Sender display name
- **Example**: `DesigninDC Roadmap`
- **Shows as**: "DesigninDC Roadmap <noreply@designindc.com>"

---

## 🔒 SECURITY

### Password Storage
- Stored in WordPress database
- Not encrypted by default
- Consider using environment variables for production

### Best Practices
1. ✅ Use app-specific passwords (Gmail)
2. ✅ Use API keys when available (SendGrid)
3. ✅ Enable 2FA on email account
4. ✅ Restrict SMTP user permissions
5. ✅ Use TLS/SSL encryption

### Production Recommendations
- Use dedicated email service (SendGrid, Mailgun)
- Don't use personal Gmail account
- Set up SPF/DKIM records
- Monitor email delivery

---

## 📧 EMAIL FLOW

### When User Submits Bug/Feature:

```
1. User fills form
   ↓
2. Form validates
   ↓
3. Submission saved to WordPress
   ↓
4. Email notification prepared
   ↓
5. Check: SMTP enabled?
   ├─ Yes → Use SMTP settings
   └─ No  → Use PHP mail()
   ↓
6. Send to: Notification Email
   ↓
7. Email delivered
   ↓
8. You receive notification!
```

---

## 🎨 EMAIL FORMAT

### Subject Line:
```
[Roadmap] New Bug Report: [Title]
[Roadmap] New Feature Request: [Title]
```

### Email Body:
```
New submission received:

Type: Bug Report / Feature Request
Title: [Submission Title]
Description: [Full Description]

Submitted by: [Name] ([Email])
Date: January 10, 2026 11:30 pm

View in admin: [Direct Link]
```

---

## 🔧 TROUBLESHOOTING

### Emails Not Sending

**Check**:
1. SMTP enabled?
2. All required fields filled?
3. Correct credentials?
4. Test email works?
5. Firewall blocking port?

**Solutions**:
- Verify SMTP settings
- Check server error logs
- Try different port (587 vs 465)
- Contact hosting provider

---

### Emails Going to Spam

**Causes**:
- Using PHP mail() instead of SMTP
- No SPF/DKIM records
- Shared hosting IP blacklisted
- "From" email doesn't match domain

**Solutions**:
- ✅ Enable SMTP
- ✅ Use professional email service
- ✅ Set up SPF/DKIM records
- ✅ Use domain-matched From email

---

### Gmail Not Working

**Common Issues**:
1. Using regular password (use app-specific)
2. 2FA not enabled
3. "Less secure apps" disabled

**Solution**:
1. Enable 2-factor authentication
2. Generate app-specific password
3. Use that password in settings

---

## 📝 EXAMPLE CONFIGURATIONS

### For Development (Local):
```
Notification Email: your-email@gmail.com
SMTP: Disabled (use PHP mail())
```

### For Production (Live Site):
```
Notification Email: bugs@designindc.com
SMTP: Enabled
Host: smtp.sendgrid.net
Port: 587
Encryption: TLS
Username: apikey
Password: [SendGrid API Key]
From Email: noreply@designindc.com
From Name: DesigninDC Roadmap
```

---

## ✅ CHECKLIST

### Initial Setup:
- [ ] Access Roadmap Settings
- [ ] Set notification email
- [ ] Decide: Use SMTP?
- [ ] If yes, configure SMTP
- [ ] Send test email
- [ ] Verify test email received
- [ ] Save settings

### Regular Maintenance:
- [ ] Check email delivery
- [ ] Monitor spam folder
- [ ] Update password if changed
- [ ] Review notification email
- [ ] Test periodically

---

## 🎉 BENEFITS

### Custom Notification Email:
- ✅ Separate from WordPress admin email
- ✅ Can use team email (bugs@company.com)
- ✅ Easy to change anytime
- ✅ Better organization

### SMTP Support:
- ✅ Reliable email delivery
- ✅ Professional sender identity
- ✅ Better spam scores
- ✅ Delivery tracking
- ✅ Works with any SMTP service

---

**Status**: ✅ **Ready to Use**  
**Location**: WordPress Admin → Roadmap Settings  
**Documentation**: Complete  
**Support**: SMTP + PHP mail()
