//
//  ETBCheckTestsCommentsView.m
//  etbook
//
//  Created by D.Gonchenko on 05.08.14.
//  Copyright (c) 2014 ETB. All rights reserved.
//

#import "ETBCheckTestsCommentsView.h"

#define kInputBorderWidth 2
#define kInputBorderColor [UIColor ETBSeparatorGrayColor].CGColor
#define kLabelFont [UIFont fontWithName:@"Comic Sans MS" size:17]
#define kLabelHeight 20
#define kCommentsHeight 40
#define kUpEdge 20
#define kLeftRightEdge 18

@interface ETBCheckTestsCommentsView () <UITextFieldDelegate>

@property (nonatomic, strong) UILabel *forStudentLabel;
@property (nonatomic, strong) UILabel *forParentsLabel;
@property (nonatomic, strong) UILabel *forTeacherLabel;

@property (nonatomic, strong) UITextField *commentForStudentTextField;
@property (nonatomic, strong) UITextField *commentForParentsTextField;
@property (nonatomic, strong) UITextField *commentForTeacherTextField;

@end

@implementation ETBCheckTestsCommentsView

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        _commentForStudent = [NSString new];
        _commentForParents = [NSString new];
        _commentForTeacher = [NSString new];
        
        [self addSubview:self.commentForStudentTextField];
        [self addSubview:self.commentForParentsTextField];
        [self addSubview:self.commentForTeacherTextField];
        [self addSubview:self.forStudentLabel];
        [self addSubview:self.forParentsLabel];
        [self addSubview:self.forTeacherLabel];
    }
    return self;
}

-(void)layoutSubviews
{
    [super layoutSubviews];
    
    _forStudentLabel.frame = CGRectMake(kLeftRightEdge,
                                        kUpEdge,
                                        self.bounds.size.width - 2*kLeftRightEdge,
                                        kLabelHeight);
    
    _commentForStudentTextField.frame = CGRectMake(kLeftRightEdge,
                                                   _forStudentLabel.frame.origin.y + kLabelHeight,
                                                   self.bounds.size.width - 2*kLeftRightEdge,
                                                   kCommentsHeight);
    
    [_commentForStudentTextField textRectForBounds:CGRectMake(20,0,_commentForStudentTextField.bounds.size.width - 10, _commentForStudentTextField.bounds.size.height)];
    
    _forParentsLabel.frame = CGRectMake(kLeftRightEdge,
                                        _commentForStudentTextField.frame.origin.y + kCommentsHeight + kUpEdge,
                                        self.bounds.size.width - 2*kLeftRightEdge,
                                        kLabelHeight);
    
    _commentForParentsTextField.frame = CGRectMake(kLeftRightEdge,
                                                   _forParentsLabel.frame.origin.y + kLabelHeight,
                                                   self.bounds.size.width - 2*kLeftRightEdge,
                                                   kCommentsHeight);
    
    _forTeacherLabel.frame = CGRectMake(kLeftRightEdge,
                                        _commentForParentsTextField.frame.origin.y + kCommentsHeight + kUpEdge,
                                        self.bounds.size.width - 2*kLeftRightEdge,
                                        kLabelHeight);
    
    _commentForTeacherTextField.frame = CGRectMake(kLeftRightEdge,
                                                   _forTeacherLabel.frame.origin.y + kLabelHeight,
                                                   self.bounds.size.width - 2*kLeftRightEdge,
                                                   kCommentsHeight);
    
    
    
}

#pragma mark - Privat interface

-(UILabel *)forStudentLabel
{
    if (!_forStudentLabel) {
        _forStudentLabel = [UILabel new];
        _forStudentLabel.font = kLabelFont;
        _forStudentLabel.textColor = [UIColor ETBPrimaryRedColor];
        _forStudentLabel.text = @"Учащемуся";
    }
    return _forStudentLabel;
}

-(UILabel *)forParentsLabel
{
    if (!_forParentsLabel) {
        _forParentsLabel = [UILabel new];
        _forParentsLabel.font = kLabelFont;
        _forParentsLabel.textColor = [UIColor ETBPrimaryRedColor];
        _forParentsLabel.text = @"Родителям";
    }
    return _forParentsLabel;
}

-(UILabel *)forTeacherLabel
{
    if (!_forTeacherLabel) {
        _forTeacherLabel = [UILabel new];
        _forTeacherLabel.font = kLabelFont;
        _forTeacherLabel.text = @"Примечание для себя";
    }
    return _forTeacherLabel;
}

- (UITextField*)commentForStudentTextField
{
    if (!_commentForStudentTextField)
    {
        _commentForStudentTextField = [UITextField new];
        
        _commentForStudentTextField.autocapitalizationType = UITextAutocapitalizationTypeNone;
        [_commentForStudentTextField setTextAlignment: NSTextAlignmentLeft];
        _commentForStudentTextField.textColor = [UIColor ETBDarkGrayColor];
        _commentForStudentTextField.autocorrectionType = UITextAutocorrectionTypeNo;
        
        _commentForStudentTextField.layer.borderColor = kInputBorderColor;
        _commentForStudentTextField.layer.borderWidth = kInputBorderWidth;
        _commentForStudentTextField.returnKeyType = UIReturnKeyNext;
        _commentForStudentTextField.borderStyle = UITextBorderStyleLine;
        _commentForStudentTextField.delegate = self;
        [_commentForStudentTextField addTarget:self action:@selector(didChangeTextInTextField:) forControlEvents:UIControlEventEditingChanged];
    }
    return _commentForStudentTextField;
}

- (UITextField*)commentForParentsTextField
{
    if (!_commentForParentsTextField)
    {
        _commentForParentsTextField = [UITextField new];
        
        [_commentForParentsTextField setTextAlignment: NSTextAlignmentLeft];
        _commentForParentsTextField.textColor = [UIColor ETBDarkGrayColor];
        _commentForParentsTextField.autocorrectionType = UITextAutocorrectionTypeNo;
        
        _commentForParentsTextField.layer.borderWidth = kInputBorderWidth;
        _commentForParentsTextField.layer.borderColor = kInputBorderColor;
        [_commentForParentsTextField canBecomeFirstResponder];
        _commentForParentsTextField.returnKeyType = UIReturnKeyNext;
        _commentForParentsTextField.borderStyle = UITextBorderStyleLine;
        _commentForParentsTextField.delegate = self;
        [_commentForParentsTextField addTarget:self action:@selector(didChangeTextInTextField:) forControlEvents:UIControlEventEditingChanged];
    }
    return _commentForParentsTextField;
}

- (UITextField*)commentForTeacherTextField
{
    if (!_commentForTeacherTextField)
    {
        _commentForTeacherTextField = [UITextField new];
        
        [_commentForTeacherTextField setTextAlignment: NSTextAlignmentLeft];
        _commentForTeacherTextField.textColor = [UIColor ETBDarkGrayColor];
        _commentForTeacherTextField.autocorrectionType = UITextAutocorrectionTypeNo;
        
        _commentForTeacherTextField.layer.borderWidth = kInputBorderWidth;
        _commentForTeacherTextField.layer.borderColor = kInputBorderColor;
        [_commentForTeacherTextField canBecomeFirstResponder];
        _commentForTeacherTextField.returnKeyType = UIReturnKeyGo;
        _commentForTeacherTextField.borderStyle = UITextBorderStyleLine;
        _commentForTeacherTextField.delegate = self;
        [_commentForTeacherTextField addTarget:self action:@selector(didChangeTextInTextField:) forControlEvents:UIControlEventEditingChanged];
    }
    return _commentForTeacherTextField;
}

#pragma mark - UITextField delegate
-(BOOL)textFieldShouldReturn:(UITextField *)textField
{
    if (textField == _commentForStudentTextField) {
        [_commentForParentsTextField becomeFirstResponder];
    }else
        if (textField == _commentForParentsTextField) {
            [_commentForTeacherTextField becomeFirstResponder];
        }else
        {
            [_commentForTeacherTextField resignFirstResponder];
        }
    
    return YES;
}

#pragma mark - UITextField change text
-(void)didChangeTextInTextField:(UITextField*)textField
{
    if (textField == _commentForStudentTextField) {
        _commentForStudent = textField.text;
    }else
        if (textField == _commentForParentsTextField) {
            _commentForParents = textField.text;
        }else
            _commentForTeacher = textField.text;
}

@end
